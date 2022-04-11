<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class PaymentsController extends Controller
{
    public function successPayments()
    {
        $payments = DB::table('payments')
            ->where('payments.amount','>',0)
            ->where('active',1)
            ->join('invoices', 'payment', '=', 'invoices.payment_id')
            ->join('transactions', 'payment', '=', 'transactions.id')
            ->select('payments.*', 'invoices.number', 'transactions.user_id', 'transactions.gateway')
            ->get();
        return view('panel.successPayments.index',compact('payments'));

    }

    public function PaymentsSearch(Request $request)
    {
       $users = User::where('mobile_number', 'LIKE', '%' . $request->input('keyword') . '%')
           ->orwhere('first_name', 'LIKE', '%' . $request->input('keyword') . '%')
           ->orwhere('last_name','LIKE','%'.$request->input('keyword').'%')->pluck('id')->toArray();
        $payments = DB::table('payments')
            ->where('payments.amount','>',0)
            ->where('active',1)
            ->join('invoices', 'payment', '=', 'invoices.payment_id')
            ->join('transactions', 'payment', '=', 'transactions.id')
            ->select('payments.*', 'invoices.number', 'transactions.user_id', 'transactions.gateway')
            ->whereIn('transactions.user_id',$users)
            ->get();
        return view('panel.successPayments.index',compact('payments'));

    }
}
