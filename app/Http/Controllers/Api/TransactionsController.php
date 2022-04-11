<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/user/saveTransactions",
     * operationId="transactions",
     * tags={"Transaction"},
     * summary="save transactions in DB",
     * description="save transactions in DB",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"transaction_id","ref_id","tracking_code","ip","code","amount","invoice_id","gateway","result_message","status"},
     *               @OA\Property(property="transaction_id", type="integer"),
     *               @OA\Property(property="ref_id", type="text"),
     *               @OA\Property(property="tracking_code", type="text"),
     *               @OA\Property(property="ip", type="text"),
     *               @OA\Property(property="code", type="integer"),
     *               @OA\Property(property="amount", type="integer"),
     *               @OA\Property(property="invoice_id", type="integer"),
     *               @OA\Property(property="gateway", type="integer"),
     *               @OA\Property(property="result_message", type="text"),
     *               @OA\Property(property="status", type="text"),

     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="OTP sent Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function saveTransactions(Request $request)
    {
        $user = Auth::user();
        $input=$request->input();
        $transaction = Transaction::create([
        'id'=>$input['transaction_id'],
        'ref_id'=>$input['ref_id'],
        'tracking_code'=>$input['tracking_code'],
        'ip'=>$input['ip'],
        'code'=>$input['code'],
        'amount'=>$input['amount'],
        'invoice_id'=>$input['invoice_id'],
        'user_id'=>$user->id,
        'gateway'=>$input['gateway'],
        'message'=>$input['result_message'],
        'status'=>$input['status'],
        ]);
        if($transaction->code ==100){
            Payment::create([
               'payment'=>$transaction->id,
                'user_id'=>$transaction->user_id,
                'description'=>'پرداخت موفق با کدرهگیری '.$transaction->tracking_code,
                'payment_method'=>1,
                'payment_receipt'=>$transaction->tracking_code,
                'amount'=>'+'.$transaction->amount,
            ]);
            $payment = Payment::create([
                'payment'=>$transaction->id,
                'user_id'=>$transaction->user_id,
                'description'=>'پرداخت موفق سفارش شماره '.$transaction->invoice_id,
                'payment_method'=>1,
                'payment_receipt'=>$transaction->tracking_code,
                'amount'=>'-'.$transaction->amount,
            ]);
            $invoice = Invoice::where('id',$transaction->invoice_id)->first();
            $invoice->payment_id = $transaction->id;
            $invoice->save();

            return response()->json(['success' => '1', 'comment' => 'تراکنش شما با موفقیت ثبت شد.']);
        }

    }
}
