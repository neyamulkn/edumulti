<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\PaymentController;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function sslCommerzPayment()
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $payment_data = Session::get('payment_data');

        if(!Session::has('payment_data')){
            return back();
        }
        $user_id = Auth::id();
        if(Session::has('offer_id')) {
            $total_price = $payment_data['total_price'] + Session::get('shipping_cost');
            $order_id = $payment_data['order_id'];
        }else{
            $total_price = $payment_data['total_price'];
            $order_id = $payment_data['order_id'];
        }

        $post_data = array();
        $post_data['total_amount'] = $total_price; # You cant not pay less than 10
        $post_data['currency'] = $payment_data['currency'];
        $post_data['tran_id'] = $order_id;  // tran_id must be unique

        # CUSTOMER INFORMATION

        $post_data['cus_name'] = Auth::user()->name;
        $post_data['cus_email'] = Auth::user()->email;
        $post_data['cus_phone'] = Auth::user()->mobile;

        # CUSTOMER INFORMATION

        $post_data['cus_add1'] = Auth::user()->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";

        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {


        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

            $sslc = new SslCommerzNotification();

            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());
            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */

                //after payment success update payment status
                $data = [
                    'order_id' => $tran_id,
                    'trnx_id' => $tran_id,
                    'payment_status' => 'paid',
                    'payment_info' => $request->input('card_issuer'),
                    'payment_method' => 'sslCommerz',
                    'status' => 'success'
                ];
                Session::put('payment_data', $data);

                $make_array = (explode('O', $tran_id));
                if(count($make_array)>1){
                    $offerPayment = new OfferController();
                    return $offerPayment->offerPrizeSelect();
                }

                $paymentController = new PaymentController();
                //redirect payment success method
                return $paymentController->paymentSuccess();
            } else {
                Toastr::error('Payment failed');
                $make_array = (explode('O', $tran_id));
                if(count($make_array)>1){
                    return back();
                }
                return Redirect::route('order.paymentGateway', $tran_id);

            }

    }

    public function fail(Request $request)
    {
        Toastr::error('Payment failed');
        if(Session::has('offer_id')){
            return back();
        }
        return Redirect::route('order.paymentGateway', $request->input('tran_id'));
    }

    public function cancel(Request $request)
    {

        Toastr::error('Payment Cancel');
        if(Session::has('payment_data')) {
            if (Session::has('offer_id')) {
                return back();
            }
            return Redirect::route('order.paymentGateway', $request->input('tran_id'));
        }
        return redirect('/');

    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $tran_id = $request->input('tran_id');

            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());
            if ($validation == TRUE) {

                //after payment success update payment status
                $data = [
                    'order_id' => $tran_id,
                    'trnx_id' => $tran_id,
                    'payment_status' => 'paid',
                    'payment_info' => $request->input('card_issuer'),
                    'payment_method' => 'sslcommerz',
                    'status' => 'success'
                ];
                Session::put('payment_data', $data);

                $paymentController = new PaymentController();
                //redirect payment success method
                return $paymentController->paymentSuccess();
            } else {
                Toastr::error('Payment failed');
                if(Session::has('offer_id')){
                    return back();
                }
                return Redirect::route('order.paymentGateway', $tran_id);
            }

        }
    }

}
