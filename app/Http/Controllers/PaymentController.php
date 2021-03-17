<?php
namespace App\Http\Controllers;

use App\Http\Controllers\PaypalController;
use App\Http\Controllers\SslCommerzPaymentController;

use App\Models\Course;
use App\Models\Order;
use App\Models\Notification;

use App\Models\PaymentGateway;
use App\Models\Transaction;
use App\Traits\CreateSlug;
use App\Traits\Sms;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class PaymentController extends Controller
{
    use CreateSlug;
    use Sms;
    //course purchase display payment gateway list in payment page
    public function coursePurchase($order_id)
    {
        $data['order'] = Order::with('courseDetails')->where('order_id', $order_id)->first();
        if($data['order']){
            $data['paymentgateways'] = PaymentGateway::orderBy('position', 'asc')->where('status', 1)->get();
            return view('frontend.courses.payment_gateway')->with($data);
        }
        return view('404');
    }

    // process payment gateway & redirect specific gateway
    public function coursePayment(Request $request, $enrolled_id){

        $user_id = Auth::id();
        $order = Order::where('user_id', Auth::id())->where('order_id', $enrolled_id)->first();
        if($order){
            $total_price = $order->price;
            $data = [
                'course_id' => $order->course_id,
                'order_id' => $enrolled_id,
                'total_price' => $total_price,
                'total_qty' => 1,
                'currency' => Config::get('siteSetting.currency_symble'),
                'payment_method' => $request->payment_method
            ];

            Session::put('payment_data', $data);
        }else{
            Toastr::error('Payment failed.');
            return redirect()->back();
        }

        if($request->payment_method == 'cash-on-delivery'){
            Session::put('payment_data.status', 'success');
            //redirect payment success method
            return $this->paymentSuccess();
        }elseif($request->payment_method == 'wallet-balance'){
            if(Auth::user()->wallet_balance >= $total_price) {
                Session::put('payment_data.status', 'success');
                Session::put('payment_data.payment_status', 'paid');
                //redirect payment success method
                return $this->paymentSuccess();
            }else{
                Toastr::error('Insufficient wallet balance.');
                return redirect()->back();
            }
        }
        elseif($request->payment_method == 'sslcommerz'){
            //redirect PaypalController for payment process
            $sslcommerz = new SslCommerzPaymentController;
            return $sslcommerz->sslCommerzPayment();
        }elseif($request->payment_method == 'paypal'){
            //redirect PaypalController for payment process
            $paypal = new PaypalController;
            return $paypal->paypalPayment();
        }
        elseif($request->payment_method == 'masterCard'){
            //redirect StripeController for payment process
            Session::put('payment_data.stripeToken', $request->stripeToken);
            $stripe = new StripeController();
            return $stripe->masterCardPayment();
        }
        elseif($request->payment_method == 'manual'){
            Session::put('payment_data.payment_method', $request->manual_method_name);
            Session::put('payment_data.status', 'success');
            Session::put('payment_data.pay_mobile_no', $request->pay_mobile_no);
            Session::put('payment_data.trnx_id', $request->trnx_id);
            Session::put('payment_data.payment_info', $request->payment_info);
            //redirect payment success method
            return $this->paymentSuccess();
        }else{
            Toastr::error('Please select payment method');
        }
        return back();
    }

    //payment status success then update payment status
    public function paymentSuccess(){

        $payment_data = Session::get('payment_data');

        //clear session payment data
        Session::forget('payment_data');
        if($payment_data && $payment_data['status'] == 'success') {
            $pay_mobile_no = ($payment_data['pay_mobile_no']) ? $payment_data['pay_mobile_no'] : null;
            $trnx_id = (isset($payment_data['trnx_id'])) ? $payment_data['trnx_id'] : null;
            $payment_info = (isset($payment_data['payment_info'])) ? $payment_data['payment_info'] : null;

            $order = Order::where('user_id', Auth::id())->where('order_id', $payment_data['order_id'])->first();
            $order->payment_method = $payment_data['payment_method'];
            $order->pay_mobile_no = $pay_mobile_no;
            $order->tnx_id = $trnx_id;
            $order->order_date = now();
            $order->payment_status = (isset($payment_data['payment_status'])) ? $payment_data['payment_status'] : 'pending';
            $order->payment_info = $payment_info;
            $order->save();

            //insert transaction
            $transaction = new Transaction();
            $transaction->type = 'order';
            $transaction->item_id = $order->order_id;
            $transaction->payment_method = $order->payment_method;
            $transaction->amount = $order->total_price;
            $transaction->author_id = $order->author_id;
            $transaction->user_id = $order->user_id;
            $transaction->from_user_id = $order->user_id;
            $transaction->status = 'paid';
            $transaction->save();

            //send mobile notify
            $mobile = ($order->user_phone) ? $order->user_phone : Auth::user()->mobile;
            $msg = 'Dear Student, your course has been successfully purchased on '.$_SERVER['SERVER_NAME'];
            $this->sendSms($mobile, $msg);
            //insert notification in database
            Notification::create([
                'type' => 'order',
                'fromUser' => Auth::id(),
                'toUser' => null,
                'item_id' => $payment_data['order_id'],
                'notify' => 'received a new order',
            ]);
            return redirect()->route('order.paymentConfirm', $payment_data['order_id']);
        }

        return redirect()->back();
    }

    //payment complete thanks page
    public function paymentConfirm($orderId){

            $order = Order::with(['courseDetails:id,title,slug,thumbnail_image'])->where('user_id', Auth::id())
                ->where('order_id', $orderId)->first();

            Toastr::success('Thanks your course purchased successful.');

            return view('frontend.courses.coursePaymentConfirm')->with(compact('order'));


    }

}
