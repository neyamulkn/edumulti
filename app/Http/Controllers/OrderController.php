<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderCancelReason;
use App\Models\Transaction;
use App\Traits\CreateSlug;
use App\Traits\Sms;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    use Sms;
    use CreateSlug;
    public function courseEnrolled($slug){
        $user_id = Auth::id();
        $course = Course::where('slug', $slug)->where('status', 'active')->first();
        if($course) {

            $order_id = $this->uniqueOrderId('orders', 'order_id');
            $total_price = $course->price;
            $coupon_discount = null;
            if (Session::has('couponAmount')) {
                $coupon_discount = (Session::get('couponType') == '%') ? round($total_price * Session::get('couponAmount'), 2) : Session::get('couponAmount');
            }
            //insert user enroll in order table
            $order = new Order();
            $order->order_id = $order_id;
            $order->course_id = $course->id;
            $order->user_id = $user_id;
            $order->user_name = Auth::user()->name;
            $order->user_phone = Auth::user()->mobile;
            $order->user_email = Auth::user()->email;
            $order->total_qty = 1;
            $order->total_price = $total_price;
            $order->coupon_code = (Session::has('couponCode') ? Session::get('couponCode') : null);
            $order->coupon_discount = $coupon_discount;

            $order->currency = Config::get('siteSetting.currency');
            $order->currency_sign = Config::get('siteSetting.currency_symble');
            $order->currency_value = Config::get('siteSetting.currency_symble');
            $order->order_date = now();
            $order->payment_status = 'pending';
            $order->order_status = 'pending';
            $order = $order->save();
            if($order){
                //redirect payment method page for payment
                return redirect()->route('coursePurchase', $order_id);
            }
        }

        Toastr::error('Something went wrong please try again.');
        return back();
    }

    //get all order by user id
    public function orderHistory($status='')
    {
        $orders = Order::with(['courseDetails:id,title,slug,thumbnail_image'])
            ->where('user_id', Auth::id());
        if($status){
            $orders = $orders->where('order_status', $status);
        }
        $data['orders'] = $orders->orderBy('id', 'desc')->get();

        return view('frontend.user.order.order-history')->with($data);
    }

    //order cancel form
    public function orderCancelForm (Request $request){
        $user_id = Auth::id();
        $data['order'] = Order::where('user_id', $user_id)->where('order_id', $request->order_id)->first();
        $data['orderCancel'] = OrderCancelReason::where('order_id', $request->order_id)->first();
        $data['cancelReasons'] = OrderCancelReason::where('order_id', null)->where('status', 1)->get();
        return view('frontend.user.order.order-cancel-form')->with($data);
    }
    //order cancel
    public function orderCancel (Request $request)
    {
        $user_id = Auth::id();
        $order = Order::where('order_status', 'pending')
            ->where('user_id', $user_id)
            ->where('order_id', $request->order_id)->first();

        if($order) {
            //insert cancel reason
            $orderCancel = new OrderCancelReason();
            $orderCancel->order_id = $request->order_id;
            $orderCancel->reason = $request->cancel_reason;
            $orderCancel->reason_details = $request->reason_details;
            $orderCancel->seller_id = $order->author_id;
            $orderCancel->user_id = $user_id;
            $orderCancel->user_type = 'student';
            if ($request->course_id) {
                $orderCancel->course_id = $request->course_id;
            }
            $orderCancel->status = 1;
            $orderCancel->save();

            //change order status
            $order->order_status = 'cancel';
            $order->updated_at = Carbon::now();
            $order->save();
            if ($order->payment_status == 'paid'){
                //add wallet balance;
                $shipping_cost = ($order->shipping_cost) ? $order->shipping_cost : 0;
                $total = $order->total_price + $shipping_cost;
                $user = User::find($user_id);
                $user->wallet_balance = $user->wallet_balance + $total;
                $user->save();

                //insert transaction
                $transaction = new Transaction();
                $transaction->type = 'wallet';
                $transaction->notes = 'order cancel';
                $transaction->item_id = $order->order_id;
                $transaction->payment_method = $order->payment_method;
                $transaction->transaction_details = $order->payment_info;
                $transaction->amount = $total;
                $transaction->total_amount = $user->wallet_balance + $total;
                $transaction->author_id = $order->author_id;
                $transaction->user_id = $order->user_id;
                $transaction->from_user_id = $order->author_id;
                $transaction->created_by = $user_id;
                $transaction->status = 'paid';
                $transaction->save();
            }
            //send mobile notify
            $customer_mobile = ($order->user_phone) ? $order->user_phone : Auth::user()->mobile;
            $msg = 'Dear customer, Your course enroll has been cancel.';
            $this->sendSms($customer_mobile, $msg);
            //notify
            Notification::create([
                'type' => 'order',
                'fromUser' => $user_id,
                'toUser' => $order->author_id,
                'item_id' => $order->course_id,
                'notify' => 'cancel order'
            ]);
            Toastr::success('Course enroll cancel successfully.');
            return back()->with('success', 'Your course enroll cancellation successfully done. Please check your wallet.');
        }else{
            Toastr::error('Course enroll can\'t cancel.');
            return back()->with('error', 'Your course enroll cancellation failed. Please try again.');
        }

    }


}
