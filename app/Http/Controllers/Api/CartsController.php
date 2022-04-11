<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use App\Models\Cart;
use App\Models\Covent;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Traits\lastPriceTrait;
use App\Traits\numberGenerateTrait;
use App\Traits\priceCalculateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    use LastPriceTrait;
    use priceCalculateTrait;
    use numberGenerateTrait;
    /**
     * @OA\Post(
     * path="/api/user/addToCart",
     * operationId="addCoventToCart",
     * tags={"Carts"},
     * summary="add covent to a user cart",
     * description="add covent to a user cart",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"covent_id","count"},
     *               @OA\Property(property="covent_id", type="text"),
     *               @OA\Property(property="count", type="integer"),
     *               @OA\Property(property="coupon_id", type="text"),
     *            ),
     *        ),
     *    ),
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'covent_id' => 'required',
            'coupon_id' =>'nullable',
            'count'=>'nullable',
        ]);
       $user =Auth::user();
       $input = $request->all();
       $input['user_id'] = $user->id;
        $carts = Cart::where('user_id',$user->id)->inCart()->pluck('covent_id')->toArray();
        if(in_array($input['covent_id'],$carts)){
            $cart = Cart::where('user_id',$user->id)->inCart()->where('covent_id',$input['covent_id'])->first();
            $cart->count+=$input['count'];
            $cart->save();
        }else {
            Cart::create($input);
        }
        return response()->json(['success' => '1', 'comment' => 'سبد خرید شما اپدیت شد.']);

    }
    /**
     * @OA\Get(
     * path="/api/user/showCart",
     * operationId="getUsersCart",
     * tags={"Carts"},
     * summary="Get list of users cart",
     * description="return list of users cart",
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function showCart()
    {
        $user =Auth::user();
        $carts = Cart::where('user_id',$user->id)->inCart()->get();
        return  new CartCollection($carts);

    }
    /**
     * @OA\Get(
     * path="/api/user/cartToInvoice",
     * operationId="cartToInvoice",
     * tags={"Carts"},
     * summary="invoice a user carts",
     * description="invoice a user carts",
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function cartToInvoice()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->inCart()->get();
        $count = Cart::where('user_id', $user->id)->inCart()->count();
        if($count != 0) {
            $cartsDiscount = $this->discountCalculate($carts);
            $cartsPrice = $this->priceCalculate($carts);
            $inputInovice = [
                'user_id' => $user->id,
                'number' => $this->numberGenerate(),
                'price' => $cartsPrice,
                'covent_discount' => $cartsDiscount,
                'payment_id' => 0,
            ];
          $invoice = Invoice::create($inputInovice);
            foreach ($carts as $cart) {
                $covent = Covent::where('id', $cart->covent_id)->first();
                $price = $this->lastPrice($covent->id);
                if ($price == null) {
                   $price['price']=0;
                    $price['discount']=0;
//
                }
                $couponDiscount = $this->discountComputing($cart);
                    $inputInvoiceDetails = [
                        'invoice_id' => $invoice->id,
                        'description' =>  $covent->title.'خرید دوره ',
                        'count' => $cart->count,
                        'price' =>  $price['price'],
                        'covent_discount' =>  $price['discount'],
                        'coupon_discount' => $couponDiscount,
                        'coupon_id' => $cart->coupon_id,
                    ];
                    $invoice_details = InvoiceDetail::create($inputInvoiceDetails);
                   $cart->update([
                        'invoice_id' => $invoice->id,
                    ]);
                   $data = [
                     'invoice_number'=>$invoice->number,
                     'price'=>$cartsPrice,
                     'discount' => $cartsDiscount,
                   ];

            }
            return response()->json(['data'=>$data, 'comment' => 'با موفقیت انجام شد.']);
        }
        return Response()->json('youre cart is empty');
    }
    /**
     * @OA\Post(
     * path="/api/user/deleteCart",
     * operationId="deleteCart",
     * tags={"Carts"},
     * summary="delete from the users cart",
     * description="delete from the users cart",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"cart_id"},
     *               @OA\Property(property="cart_id", type="integer"),
     *
     *            ),
     *        ),
     *    ),
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function deleteCart(Request $request)
    {
        $user = Auth::user();
        $cartId = $request->input('cart_id');
        $cart = Cart::where('id',$cartId)->inCart()->first();
        if(isset($cart)){
            if($cart->user_id == $user->id){
                $cart->delete();
                return Response()->json('your cart deleted successfully');
            }else{
                return Response()->json('you can not delete this cart');
            }
        }else{
            return Response()->json('this item is not exists in your cart');
        }
    }
    /**
     * @OA\Post(
     * path="/api/user/updateCart",
     * operationId="updateCart",
     * tags={"Carts"},
     * summary="update the users cart",
     * description="update the users cart",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"cart_id","count"},
     *               @OA\Property(property="cart_id", type="integer",),
     *               @OA\Property(property="count", type="integer",),
     *
     *            ),
     *        ),
     *    ),
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function updateCart(Request $request)
    {
        $user = Auth::user();
        $cartId = $request->input('cart_id');
        $cart = Cart::where('id',$cartId)->inCart()->first();
        if(isset($cart)){
            if($cart->user_id == $user->id){
                $cart->update([
                    'count' => $request->input('count'),
                ]);
                return Response()->json('your cart updated successfully');
            }else{
                return Response()->json('you can not update this cart');
            }
        }else{
            return Response()->json('this item is not exists in your cart anymore');
        }
    }

    /**
     * @OA\Post(
     * path="/api/user/showInvoice",
     * operationId="show user invoice",
     * tags={"Invoices"},
     * summary="show user invoices",
     * description="show user invoices",
    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="number", type="integer"),
     *
     *            ),
     *        ),
     *    ),
    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     * )
     */

    public function showInvoice(Request $request)
    {
        $user = Auth::user();
        $invoiceNumber = $request->input('number');
        if (isset($invoiceNumber)){
            $invoice = Invoice::where('number', $invoiceNumber)->where('user_id', $user->id)
                ->select('id','number','price','covent_discount','coupon_discount','payment_id','created_at')
                ->with('invoice_details:invoice_id,description,count,price,covent_discount,coupon_discount,coupon_id,created_at')->first();
            return Response()->json($invoice);
        }
        else{
            $invoices = Invoice::where('user_id', $user->id)
                ->select('id','number','price','covent_discount','coupon_discount','payment_id','created_at')
                ->with('invoice_details:invoice_id,description,count,price,covent_discount,coupon_discount,coupon_id,created_at')->get();
            return Response()->json($invoices);

        }
    }
}
