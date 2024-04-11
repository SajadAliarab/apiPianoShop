<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
  /**
   * @OA\Post(
   ** path="/api/v1/register_user",
   *  tags={"Auth Api"},
   *  description="use for register user to database",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="name",
   *                  description="Enter your name",
   *                  type="string",),
   *           @OA\Property(
   *                  property="email",
   *                  description="Enter your email",
   *                  type="string",),
   *           @OA\Property(
   *                  property="password",
   *                  description="Enter your password",
   *                  type="string",
   *               ),
   *     )
   *   )
   * ),
   *   @OA\Response(
   *      response=200,
   *      description="Its Ok",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   )
   *)
   **/
  public function RegisterUser(Request $request)
  {
    if ($request != null) {
      $name = $request->input('name');
      $email = $request->input('email');
      $password = $request->input('password');
      User::query()->create([
        'name' => $name,
        'email' => $email,
        'password' => $password
      ]);

      return Response()->json([
        'result' => true,
        'message' => "user have inserted",
        'data' => [
          'name' => $name,
          'email' => $email,
          'password' => $password
        ]
      ], 200);
    } else {
      return Response()->json([
        'result' => false,
        'message' => "access denied",
        'data' => []
      ], 403);
    }
  }
  /**
   * @OA\Post(
   ** path="/api/v1/login_user",
   *  tags={"Auth Api"},
   *  description="use for login user ",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="email",
   *                  description="Enter your email",
   *                  type="string",),
   *           @OA\Property(
   *                  property="password",
   *                  description="Enter your password",
   *                  type="string",),
   *     )
   *   )
   * ),
   *   @OA\Response(
   *      response=200,
   *      description="Its Ok",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   )
   *)
   **/
  public function LoginUser(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);
    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      $token = $user->createToken('AuthToken')->plainTextToken;
      return response()->json([
        'result'=>true,
        'message' => 'Login successful',
        'data'=> $token
      ], 200);
    } else {
      return response()->json([
        'message' => 'Invalid credentials'
      ], 401);
    }
  }

  /**
   * @OA\Post(
   ** path="/api/v1/user_token_logout/{token}",
   *  tags={"Auth Api"},
   *  description="use for logout user by token",
   * @OA\Parameter(
   *        name="token",
   *       in="path",
   *      required=true,
   *     description="Enter your token",
   *    @OA\Schema(
   *          type="string"
   *   )
   * ),
   *   @OA\Response(
   *      response=200,
   *      description="Its Ok",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   )
   *)
   **/

 
  public function LogoutUser($tokenHasshed)
  {
    $token = PersonalAccessToken::findToken($tokenHasshed);
    if(!$token){
      return response()->json([
        'result'=>false,
        'message' => 'Token not found',
      ], 404);
    }else{
    $token->delete();
    return response()->json([
      'result'=>true,
      'message' => 'Logout successful',
    ], 200);
  }
  }

  /**
   * @OA\Get(
   ** path="/api/v1/user_token/{token}",
   *  tags={"Auth Api"},
   *  description="use for get user by token",
   * @OA\Parameter(
   *        name="token",
   *       in="path",
   *      required=true,
   *     description="Enter your token",
   *    @OA\Schema(
   *          type="string"
   *   )
   * ),
   *   @OA\Response(
   *      response=200,
   *      description="Its Ok",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   )
   *)
   **/
  public function getUserByToken($tokenHasshed)
  {
    $token = PersonalAccessToken::findToken($tokenHasshed);

    if($token){
      // Retrieve user based on the token
      $user = $token->tokenable;

    if($user){
      return response()->json([
        'result'=>true,
        'message' => 'User found',
        'data'=>[
          'user'=>$user->id,
          'role'=>$user->role,
        ]
      ], 200);
    }else{
      return response()->json([
        'result'=>false,
        'message' => 'User not found',
      ], 404);
    }
  }else{
    return response()->json([
      'result'=>false,
      'message' => 'Token not found',
    ], 404);

  }
 
}
}
