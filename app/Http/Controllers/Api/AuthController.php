<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Api;

use App\Models\Organizer;
use App\Models\Role;
use Ferdous\OtpValidator\Constants\StatusCodes;
use Ferdous\OtpValidator\Object\OtpValidateRequestObject;
use Ferdous\OtpValidator\OtpValidator;
use Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Ferdous\OtpValidator\Services\OtpService;
use Ferdous\OtpValidator\Object\OtpRequestObject;
use Illuminate\Support\Facades\Auth;
use Kavenegar\KavenegarApi;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/update_profile",
     * operationId="update_profile",
     * tags={"Profile"},
     * summary="User update profile",
     * description="User update profile",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={},
     *               @OA\Property(property="first_name", type="text"),
     *               @OA\Property(property="last_name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="updated Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="updated Successfully",
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
    public function update_profile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email',
        ]);
        $user = Auth::user();
        if(isset($validated['first_name']))
            $user->first_name = $validated['first_name'];
        if(isset($validated['last_name']))
            $user->last_name = $validated['last_name'];
        if(isset($validated['email']))
            $user->email = $validated['email'];
        $success = $user->save();
        return response()->json(['success' => $success]);
    }

    /**
     * @OA\Post(
     * path="/api/login_with_otp",
     * operationId="login_with_otp",
     * tags={"Login"},
     * summary="User login with otp",
     * description="Login User Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"mobile_number", "otp_code"},
     *               @OA\Property(property="mobile_number", type="text"),
     *               @OA\Property(property="otp_code", type="text")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
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
    public function login_with_otp(Request $request)
    {
        $validated = $request->validate([
            'mobile_number' => 'required',
            'otp_code' => 'required'
        ]);
        $otp_code = $validated['otp_code'];
        $mobile_number = $validated['mobile_number'];
        $uuid = md5($mobile_number);
        $validation_result = OtpValidator::validateOtp(
            new OtpValidateRequestObject($uuid,$otp_code)
        );
        if ($validation_result['code'] != StatusCodes::OTP_VERIFIED) {
            return response()->json(['error' => 'Unauthorised'], 401);
        } else {
            $user = User::where('mobile_number', $mobile_number)->first();
            if(!$user){
                return response()->json(['error' => 'Mobile number not found'], 401);
            }
            $success['token'] = $user->createToken('authToken')->accessToken;
            $success['user'] = $user;
            return response()->json(['success' => $success])->setStatusCode(200);
        }
    }

    /**
     * @OA\Post(
     * path="/api/send_sms_otp",
     * operationId="auth_login",
     * tags={"OTP"},
     * summary="send otp to the user",
     * description="send otp code to user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"mobile_number"},
     *               @OA\Property(property="mobile_number", type="number"),
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
    public function send_sms_otp(Request $request)
    {
        $validated = $request->validate([
            'mobile_number' => 'required'
        ]);
        $mobile_number = $validated['mobile_number'];
        $otp_id = $mobile_number;
        $type = config('sms-service.opt_type');
        $otp_req_obj = new OtpRequestObject($otp_id, $type, $mobile_number);
        try {
            OtpService::expireOldOtpRequests($otp_req_obj);

            // Resend Exceed
            if(OtpService::countResend($otp_req_obj) > config('otp.max-resend'))
                return response()->json(['error' => 'max sms limit reached.'], 501);

            // OTP Generation and Persistence
            $otp_code = OtpService::otpGenerator();
            $uuid = md5($otp_req_obj->client_req_id);
            OtpService::createOtpRecord($otp_req_obj, $otp_code, $uuid);

            // Send OTP
            $api = new KavenegarApi(config('sms-service.api_key') );
            $result = $api->VerifyLookup($otp_req_obj->number, $otp_code, '', '', $otp_req_obj->type);

            if(!$result){
                return response()->json(['error' => 'sending sms failed.'], 501);
            }
            $result['uuid'] = $uuid;
            return $result;
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 501);
        }
    }

    /**
     * @OA\Post(
     * path="/api/validate_sms_otp",
     * operationId="validateOTPCode",
     * tags={"OTP"},
     * summary="validates otp code sent to the user",
     * description="send otp code to user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"mobile_number", "otp_code"},
     *               @OA\Property(property="mobile_number", type="number"),
     *               @OA\Property(property="otp_code", type="number")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="OTP validated Successfully",
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
    public function validate_sms_otp(Request $request)
    {
        $validated = $request->validate([
            'mobile_number' => 'required|numeric',
            'otp_code' => 'required'
        ]);
        $uuid = md5($validated['mobile_number']);
        $otp_code = $validated['otp_code'];
        return OtpValidator::validateOtp(
            new OtpValidateRequestObject($uuid,$otp_code)
        );
    }

    /**
     * @OA\Post(
     * path="/api/register",
     * operationId="Register",
     * tags={"Register"},
     * summary="User Register",
     * description="User Register here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"first_name", "last_name", "password"},
     *               @OA\Property(property="first_name", type="text"),
     *               @OA\Property(property="last_name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="mobile_number", type="text"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Register Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
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
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required'
            ,
            'last_name' => 'required',
            'email' => 'email|unique:users',
            'password' => 'required',
            'mobile_number' => 'numeric|unique:users',
        ]);
        if(!isset($validated['mobile_number']) && !isset($validated['email'])){
            return response()->json(['message' => 'You should enter an email or a mobile number.'], 400);
        }
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $role = Role::where('name','User')->first();
        $user->roles()->attach($role->id);
        $success['token'] =  $user->createToken('authToken')->accessToken;
        $success['first_name'] =  $user->first_name;
        $success['last_name'] =  $user->last_name;
        return response()->json(['success' => $success]);
    }
    /**
     * @OA\Post(
     * path="/api/organizerRegister",
     * operationId="OrganizerRegister",
     * tags={"Register"},
     * summary="Organizer Register",
     * description="organizer Register here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"first_name", "last_name", "password","is_company"},
     *               @OA\Property(property="first_name", type="text"),
     *               @OA\Property(property="last_name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="mobile_number", type="text"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="is_company", type="boolean"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Register Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Register Successfully",
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
    public function organizerRegister(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:users',
            'password' => 'required',
            'mobile_number' => 'numeric|unique:users',
            'is_company' =>'required|boolean',
        ]);
        if(!isset($validated['mobile_number']) && !isset($validated['email'])){
            return response()->json(['message' => 'You should enter an email or a mobile number.'], 400);
        }
        $input = $request->except('is_company','name');
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
       $name = $request->input('name');
        if(!isset($name)){
            $name = $input['first_name'].' '.$input['last_name'];
        }

        $organizer=[
            'is_company' => $request->input('is_company'),
            'name'=>$name,
            'user_id'=>$user->id,
        ];

        $organizer =Organizer::create($organizer);
        $userrole = Role::where('name','User')->first();
        $organizerrole = Role::where('name','Organizer')->first();
        $user->roles()->attach($userrole->id);
        $user->roles()->attach($organizerrole->id);
        $success['token'] =  $user->createToken('authToken')->accessToken;
        $success['first_name'] =  $user->first_name;
        $success['last_name'] =  $user->last_name;
        return response()->json(['success' => $success]);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * operationId="authLogin",
     * tags={"Login"},
     * summary="User Login",
     * description="Login User Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
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
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($validator)) {
            return response()->json(['error' => 'Unauthorised'], 401);
        } else {
            $success['token'] = auth()->user()->createToken('authToken')->accessToken;
            $success['user'] = auth()->user();
            return response()->json(['success' => $success])->setStatusCode(200);
        }
    }

    /**
     * @OA\Post(
     * path="/api/login_with_mobile",
     * operationId="LoginWithMobile",
     * tags={"Login"},
     * summary="User Login with mobile",
     * description="Login User Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"mobile_number", "password"},
     *               @OA\Property(property="mobile_number", type="number"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
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
    public function login_with_mobile(Request $request)
    {
        $validator = $request->validate([
            'mobile_number' => 'required|numeric',
            'password' => 'required'
        ]);

        if (!auth()->attempt($validator)) {
            return response()->json(['error' => 'Unauthorised'], 401);
        } else {
            $success['token'] = auth()->user()->createToken('authToken')->accessToken;
            $success['user'] = auth()->user();
            return response()->json(['success' => $success])->setStatusCode(200);
        }
    }

    /**
     * @OA\Post(
     * path="/api/user/changePassword",
     * operationId="change password",
     * tags={"OTP"},
     * summary="change password with otp",
     * description="change pass word with otp here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"mobile_number", "otp_code","newPassword"},
     *               @OA\Property(property="mobile_number", type="text"),
     *               @OA\Property(property="newPassword", type="text"),
     *               @OA\Property(property="otp_code", type="text")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="change password Successfully",
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
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'newPassword' => 'required',
            'otp_code' => 'required',
            'mobile_number' => 'required',
        ]);
        $otp_code = $validated['otp_code'];
        $password = $validated['newPassword'];
        $mobile_number = $validated['mobile_number'];
        $uuid = md5($mobile_number);
        $validation_result = OtpValidator::validateOtp(
            new OtpValidateRequestObject($uuid,$otp_code)
        );
        if ($validation_result['code'] != StatusCodes::OTP_VERIFIED) {
            return response()->json(['error' => 'Unauthorised'], 401);
        } else {
            $user = User::where('mobile_number', $mobile_number)->first();
            $password = Hash::make($password);
            $user->password = $password;
            $user->save();
            $success['token'] = $user->createToken('authToken')->accessToken;
            $success['user'] = $user;
            return response()->json(['success' => $success])->setStatusCode(200);
        }
    }
}
