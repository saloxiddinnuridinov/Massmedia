<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    /**
     *     @OA\Post (
     *      path="/api/v1/login",
     *      tags={"Auth"},
     *      summary="Login System User",
     *      description="Authorization",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Login page",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email","password"},
     *                   @OA\Property(property="email", type="string", format="text", example="admin@gmail.com"),
     *                  @OA\Property(property="password", type="string", format="text", example="admin123"),
     *              )
     *          )
     *      ),
     *  @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", example="admin@gmail.com"),
     *              @OA\Property(property="password", type="string", example="admin123"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     * 
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];	
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }else{
            $credentials = request(['email', 'password']);
            $email = $request->email;
            $password = $request->password;
            $system_user = SystemUser::where('email', $email)->first();
            //return $system_user;
            if($system_user){
                if (Hash::check($password, $system_user->password)) {
                    if ($token = auth()->attempt($credentials)) {
                        $this->me($token);
                        $user = auth()->user();
                        return response()->json(['data' => $user, 'authorization' => $this->respondWithToken($token)], 200);
                    } else {
                        return response()->json(['data' => [], 'errors' => ['authorization' => 'Unauthorization']], 401);
                    }
                } else {
                    return response()->json(['data' => [], 'errors' => ['password' => 'Wrong password!']], 403);
                }
            }else{
                return response()->json(['data' => [], 'errors' => ['email' => 'System User not found']], 404);
            }
        }
    }
     /**
     *     @OA\Post (
     *      path="/api/v1/register",
     *      tags={"Auth"},
     *      summary="Register",
     *      description="Returns columns of cart belongs to customer",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="name", type="number", example="Uzbekistan"),
     *          ),
     *      ),
     *       @OA\RequestBody(
     *          required=true,
     *          description="Register page",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","middlename","surname","email","language","password", "password_confirmation"},
     *                  @OA\Property(property="name", type="string", format="text", example="Salohiddin"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="Saloh"),
     *                  @OA\Property(property="surname", type="string", format="text", example="Nuridinov"),
     *                  @OA\Property(property="email", type="string", format="text", example="admin@gmail.com"),
     *                  @OA\Property(property="phone", type="string", format="text", example="+998901234567"),
     *                  @OA\Property(property="language", type="string", format="text", example="uz"),
     *                  @OA\Property(property="password", type="string", format="text", example="admin123"),
     *                  @OA\Property(property="password_confirmation", type="string", format="text", example="admin123"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     * )
     */
    public function register(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:system_users',
            'language' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ];	
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(),400);
        }else{
            $system_user = SystemUser::create([
                'name' => $request->name,
                'middlename' => $request->middlename,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'language' => $request->language,
                'password' => Hash::make($request->password),
            ]);
            $system_user = auth()->login($system_user);
            $token = $this->me($system_user);
            //return $system_user;
            return response()->json([
                'status' => 'success',
                'message' => 'System User created successfully',
                'user' => $system_user,
                'authorisation' => $this->respondWithToken($token)
            ]);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
