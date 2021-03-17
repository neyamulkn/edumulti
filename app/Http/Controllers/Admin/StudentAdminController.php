<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Transaction;
use App\Traits\Sms;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class StudentAdminController extends Controller
{
    use Sms;
    public function studentList(Request $request, $status= ''){
        $students  = User::with('get_orders:user_id');
        if($status){
            $students->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $students->where('status', $request->status);
        }if($request->name && $request->name != 'all'){
            $keyword = $request->name;
            $students->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'like', '%' . $keyword . '%');
                $query->orWhere('mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }if($request->location && $request->location != 'all'){
            $students->where('city', $request->location);
        }
        $students  = $students->orderBy('id', 'desc')->where('role', 'student')->paginate(15);
        $locations = City::orderBy('name', 'asc')->get();
        return view('admin.student.student')->with(compact('students', 'locations'));
    }

    public function studentProfile($username){
        $student  = User::with('get_orders')->where('username', $username)->first();
        return view('admin.student.profile')->with(compact('student'));
    }

    public function studentSecretLogin($id)
    {
        $user = User::findOrFail(decrypt($id));

        auth()->guard('web')->login($user, true);

        Toastr::success('student panel login success.');
        return redirect()->route('user.dashboard');

    }

    public function delete($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            $output = [
                'status' => true,
                'msg' => 'Student deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Student cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function walletHistory(){
        $data['totalBalance'] = User::where('wallet_balance', '>', 0)->sum('wallet_balance');
        $data['allWallets'] = Transaction::with(['student:id,name,username,mobile', 'addedBy'])->where('type', 'wallet')->orderBy('id', 'desc')->paginate(15);
        return view('admin.wallet.wallet')->with($data);
    }

    public function studentWalletInfo(Request $request){
        $student = User::where('name', $request->student)->orWhere('mobile', $request->student)->orWhere('email', $request->student)->first();
        if($student) {
            return view('admin.wallet.studentWalletInfo')->with(compact('student'));
        }
        return false;
    }

    public function walletRecharge(Request $request){
        $request->validate([
            'amount' => 'required',
            'transaction_details' => 'required',
        ]);

        $student = User::find($request->student_id);
        if($student) {
            $old_balance = $student->wallet_balance;
            if ($request->wallet_type == 'add') {
                $amount =  '+'.$request->amount;
                $total_amount =  $old_balance + $request->amount;
            }
            if ($request->wallet_type == 'minus') {
                $amount =  '-'.$request->amount;
                $total_amount =  $old_balance - $request->amount;
            }
            $student->wallet_balance = $total_amount;
            $student->save();

            //insert transaction
            $transaction = new Transaction();
            $transaction->type = 'wallet';
            $transaction->notes = $request->notes;
            $transaction->item_id = $student->id;
            $transaction->payment_method = $request->payment_method;
            $transaction->transaction_details = $request->transaction_details;
            $transaction->amount = $amount;
            $transaction->total_amount = $total_amount;
            $transaction->user_id = $student->id;
            $transaction->created_by = Auth::guard('admin')->id();
            $transaction->status = 'paid';
            $transaction->save();
            Toastr::success($student->name.'\'s wallet recharge success.');
            //send sms notify
            if($student->mobile) {
                $student_mobile = $student->mobile;
                $wallet_type = ($request->wallet_type == 'minus') ? 'minus ' : 'added ';
                $msg = 'Dear student, ' . $wallet_type . $request->amount . Config::get('siteSetting.currency_symble') . ' to your wallet. Current balance ' . $total_amount . Config::get('siteSetting.currency_symble') . ' get up to 70% discount at '.$_SERVER['SERVER_NAME'];
                $this->sendSms($student_mobile, $msg);
            }
        }else{
            Toastr::error('Wallet recharge failed student not found.');
        }
        return back();
    }
}
