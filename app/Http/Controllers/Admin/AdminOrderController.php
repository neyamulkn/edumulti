<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderCancelReason;
use App\Models\Transaction;
use App\Traits\Sms;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    use Sms;
    //get all order by user id
    public function orderHistory(Request $request, $status='')
    {
        $orderCount = Order::where('payment_method', '!=', 'pending')->select('order_status')->get();

        $orders = Order::orderBy('order_date', 'desc')->where('payment_method', '!=', 'pending')
            ->join('courses', 'orders.course_id', 'courses.id')
            ->join('users', 'orders.user_id', 'users.id');
        if($request->enroll_id){
            $orders->where('order_id', $request->enroll_id);
        }
        if($request->student){
            $keyword = $request->student;
                $orders->where(function ($query) use ($keyword) {
                $query->orWhere('orders.name', 'like', '%' . $keyword . '%');
                $query->orWhere('orders.phone', 'like', '%' . $keyword . '%');
                $query->orWhere('orders.email', 'like', '%' . $keyword . '%');
                $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                $query->orWhere('users.mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('users.email', 'like', '%' . $keyword . '%');
            });
        }
        //status pending,active,reject
        if($status){
            $orders = $orders->where('order_status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $orders = $orders->where('order_status',$request->status);
        }
        if($request->from_date){
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
            $orders = $orders->where('order_date', '>=', $from_date);
        }if($request->end_date){
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
            $orders = $orders->where('order_date', '<=', $request->end_date);
        }

        $orders = $orders->selectRaw('orders.*,courses.title,courses.slug, courses.thumbnail_image, users.name as student_name,username')->paginate(15);
        return view('admin.order.orders')->with(compact('orders', 'orderCount'));
    }

    //show order details by order id
    public function showorderDetails($orderId){

        $order = Order::with(['course:id,title,slug,thumbnail_image','get_country', 'get_state', 'get_city', 'get_area'])
            ->where('order_id', $orderId)->first();
        if($order){
            return view('admin.order.order-details')->with(compact('order'));
        }
        return false;
    }

    //show order details by order id
    public function orderInvoice($orderId){
        $order = Order::with(['courseDetails:id,title,slug,thumbnail_image'])
            ->where('order_id', $orderId)->first();

        if($order){
            return view('admin.order.invoice')->with(compact('order'));
        }
        return view('404');
    }

    //add 0r chanage shipping method
    public function shippingMethod(Request $request){
        $order = Order::where('order_id', $request->order_id)->first();
        if($order){
            $order->shipping_method_id = $request->shipping_method_id;
            $order->save();
            $output = array( 'status' => true,  'message'  => 'Shipping method set successful.');
        }else{
            $output = array( 'status' => false,  'message'  => 'Shipping added failed.!');
        }
        return response()->json($output);
    }


    // change payment Status function
    public function changePaymentStatus(Request $request){
        $status = Order::where('order_id', $request->order_id)->first();
        if($status){
            $status->update(['payment_status' => $request->status]);
            $output = array( 'status' => true,  'message'  => 'Payment status '.str_replace( '-', ' ', $request->status).' successful.');
        }else{
            $output = array( 'status' => false,  'message'  => 'Payment status update failed.!');
        }
        return response()->json($output);
    }

    // add order info exm( shipping cost, comment)
    public function addedorderInfo(Request $request){
        $order = Order::where('order_id', $request->order_id)->first();
        if($order){
            if($request->field_data) {
                $field = $request->field;
                $order->$field = ($request->field_data) ? $request->field_data : null;
                $order->save();
            }
            $output = array( 'status' => true,  'message'  => str_replace( '_', ' ', $request->field).' added successful.');
        }else{
            $output = array( 'status' => false,  'message'  => str_replace( '_', ' ', $request->field).' added failed.');
        }
        return response()->json($output);
    }


    // change order Status function
    public function changeorderStatus(Request $request){
        $order = Order::where('order_id', $request->order_id)->first();
        $status = str_replace( '-', ' ', $request->status);
        $output = [];
        if($order && $order->order_status != $request->status && $order->order_status != 'delivered'){
            $order->update(['order_status' => $request->status]);
            $total = $order->total_price;
            //get user info
            $user = User::find($order->user_id);
            //check status delivered
            if($request->status == 'delivered'){
                //insert transaction
                $transaction = new Transaction();
                $transaction->type = 'order';
                $transaction->item_id = $order->order_id;
                $transaction->payment_method = $order->payment_method;
                $transaction->amount = $total;
                $transaction->author_id = $order->author_id;
                $transaction->user_id = $order->user_id;
                $transaction->from_user_id = $order->user_id;
                $transaction->status = 'paid';
                $transaction->save();
            }

            //if cancel order add wallet balance;
            if ($order->payment_status == 'paid' && $request->status == 'cancel'){
                // add user wallet balance
                $user->wallet_balance = $user->wallet_balance + $total;
                $user->save();

                //insert transaction
                $transaction = new Transaction();
                $transaction->type = 'wallet';
                $transaction->notes = 'order '. $request->status;
                $transaction->item_id = $order->order_id;
                $transaction->payment_method = $order->payment_method;
                $transaction->transaction_details = $order->payment_info;
                $transaction->amount = $total;
                $transaction->total_amount = $user->wallet_balance + $total;
                $transaction->author_id = $order->author_id;
                $transaction->user_id = $order->user_id;
                $transaction->from_user_id = $order->author_id;
                $transaction->created_by = Auth::guard('admin')->id();
                $transaction->status = 'paid';
                $transaction->save();
            }
            $staff_id = Auth::guard('admin')->id();
            $order->updated_by = $staff_id;
            $order->save();

            //send mobile notify
            $msg = 'Dear student, Your course enroll has been '.$status.'. Thanks for purchase from '.$_SERVER['SERVER_NAME'];
            $student_mobile = ($order->user_phone) ? $order->user_phone : $order->shipping_phone;
            $this->sendSms($student_mobile, $msg);

            //insert notification in database
            Notification::create([
                'type' => 'orderStatus',
                'fromUser' => $staff_id,
                'toUser' => $order->user_id,
                'item_id' => $request->order_id,
                'notify' => $request->status.' your order',
            ]);

            $output = array( 'status' => true,  'message'  => 'Course enroll status '.$status.' successful.');
        }else{
            $output = array( 'status' => false,  'message'  => 'Course enroll status update failed.!');
        }
        return response()->json($output);
    }

    //order cancel
    public function orderCancel ($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();
        $output = [];
        if($order && $order->order_status != 'delivered') {
                $order->update(['order_status' => 'cancel']);

                    //if cancel order add wallet balance;
                    if ($order->payment_status == 'paid'){
                        $shipping_cost = ($order->shipping_cost) ? $order->shipping_cost : 0;
                        $total = $order->total_price + $shipping_cost;
                        $user = User::find($order->user_id);
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
                        $transaction->created_by = Auth::guard('admin')->id();
                        $transaction->status = 'paid';
                        $transaction->save();
                    }
                    $staff_id = Auth::guard('admin')->id();

                    $order->updated_by = $staff_id;
                    $order->save();

                    //send mobile notify
                    $student_mobile = $order->user_phone;
                    $msg = 'Dear student, Your course enroll has been cancel. Thanks for purchase from '.$_SERVER['SERVER_NAME'];
                    $this->sendSms($student_mobile, $msg);

                    //insert notification in database
                    Notification::create([
                        'type' => 'order',
                        'fromUser' => $staff_id,
                        'toUser' => $order->user_id,
                        'item_id' => $order->order_id,
                        'notify' => 'cancel your order',
                    ]);
                    $output = [
                        'status' => true,
                        'msg' => 'Course enroll cancel successfully.'
                    ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Course enroll cancel failed.'
            ];
        }
        return response()->json($output);
    }

    //set refund days
    public function refundConfig(){
        return view('admin.refund.returnConfigure');
    }

    //order cancel reason lists
    public function OrderCancelReason()
    {
        $reasons = OrderCancelReason::where('order_id', null)->get();
        return view('admin.order.cancel-reason')->with(compact('reasons'));
    }

    //insert return reason
    public function reasonStore(Request $request)
    {
        $reason = new OrderCancelReason();
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $reason->user_type = ($request->user_type) ? 1 : 'student';
        $store = $reason->save();
        Toastr::success('order Cancel Reason Insert Success.');
        return back();
    }

    //edit reason
    public function reasonEdit($id)
    {
        $data = OrderCancelReason::find($id);
        echo view('admin.order.cancel-reason-edit')->with(compact('data'));
    }
    //update data
    public function reasonUpdate(Request $request)
    {
        $reason = OrderCancelReason::find($request->id);
        $reason->reason = $request->reason;
        $reason->status = ($request->status) ? 1 : 0;
        $store = $reason->save();
        Toastr::success('order Cancel Reason update Success.');
        return back();
    }

    //delate reason
    public function reasonDelete($id)
    {
        $reason = OrderCancelReason::where('id', $id)->delete();

        if($reason){
            $output = [
                'status' => true,
                'msg' => 'Reason deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Reason cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
