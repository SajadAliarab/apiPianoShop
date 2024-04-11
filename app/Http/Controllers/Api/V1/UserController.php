<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     /**
   * @OA\Get(
   ** path="/api/v1/user_show_by_id/{id}",
   *  tags={"User Api"},
   *  description="use for get user data",
   * @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="ID of the user",
   *      required=true,
   *      @OA\Schema(
   *          type="integer"
   *      )
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
  public function getUserById($id)
  {
    $user = User::query()->find($id);
    return response()->json([
      'result' => true,
      'message' => 'User data',
      'data' => $user
    ], 200);
  }

/** @OA\Post(
   ** path="/api/v1/change_password/{id}",
   *  tags={"User Api"},
   *  description="use for change password",
   * @OA\Parameter(
   *     name="id",
   *    in="path",
   *   description="ID of the user",
   *  required=true,
   * @OA\Schema(
   *    type="integer"
   * )
   * ),
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
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

public function changePassword(Request $request, $id)
{
    $user = User::query()->find($id);
    $user->password = $request->input('password'); 
    $user->save();
  return response()->json([
    'result' => true,
    'message' => 'Password changed successfully'
  ], 200);
}

/** @OA\Delete(
   ** path="/api/v1/user_delete/{id}",
   *  tags={"User Api"},
   *  description="use for delete user",
   * @OA\Parameter(
   *     name="id",
   *    in="path",
   *   description="ID of the user",
   *  required=true,
   * @OA\Schema(
   *    type="integer"
   * )
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
public function deleteUser($id)
{
    $user = User::query()->find($id);
    $user->delete();
  return response()->json([
    'result' => true,
    'message' => 'User deleted successfully'
  ], 200);
}

/** @OA\Put(
   ** path="/api/v1/user_update/{id}",
   *  tags={"User Api"},
   *  description="use for update user",
   * @OA\Parameter(
   *     name="id",
   *    in="path",
   *   description="ID of the user",
   *  required=true,
   * @OA\Schema(
   *    type="integer"
   * )
   * ),
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="name",
   *                  description="Enter your name",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="email",
   *                  description="Enter your email",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="role",
   *                  description="Enter your role",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="phone",
   *                  description="Enter your phone",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="address",
   *                  description="Enter your address",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="country",
   *                  description="Enter your country",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="city",
   *                  description="Enter your city",
   *                  type="string",
   *               ),
   *           @OA\Property(
   *                  property="postCode",
   *                  description="Enter your postCode",
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
public  function updateUser(Request $request, $id)
{
    $user = User::query()->find($id);
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->role = $request->input('role');
    $user->phone= $request->input('phone');
    $user->address = $request->input('address');
    $user->country = $request->input('country');
    $user->city = $request->input('city');
    $user->postCode = $request->input('postCode');
    $user->save();
    return response()->json([
        'result' => true,
        'message' => 'User updated successfully'
    ], 200);
  }

/** @OA\Get(
   ** path="/api/v1/users_show",
   *  tags={"User Api"},
   *  description="use for get all user data",
   *   @OA\Response(
   *      response=200,
   *      description="Its Ok",
   *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *   )
   *)
   **/
  public function getUsers()
  {
    $users = User::query()->get();
    if($users){
    return response()->json([
      'result' => true,
      'message' => 'User data',
      'data' => $users
    ], 200);
  }else{
    return response()->json([
      'result' => false,
      'message' => 'No data found'
    ], 404);
  }
}
}