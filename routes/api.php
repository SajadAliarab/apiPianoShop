<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SlideController;
use App\Http\Controllers\Api\V1\FileController;
use App\Http\Controllers\Api\V1\ProductDetailsController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\paymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->namespace('api\v1')->group(function(){
    Route::post('register_user',[AuthController::class,'RegisterUser']);
    Route::post('login_user',[AuthController::class,'LoginUser']);
    Route::post('user_token/{token}',[AuthController::class,'getUserByToken']);
    Route::post('user_token_logout/{token}',[AuthController::class,'logoutUser']);
    Route::get('user_show_by_id/{id}',[UserController::class,'getUserById']);
    Route::put('change_password/{id}',[UserController::class,'changePassword']);
    Route::delete('user_delete/{id}',[UserController::class,'deleteUser']);
    Route::put('user_update/{id}',[UserController::class,'updateUser']);
    Route::get('users_show',[UserController::class,'getUsers']);
    Route::post('upload_file',[FileController::class,'upload']);
    Route::delete('delete_file/{fileName}',[FileController::class,'deleteFile']);
    Route::post('slide_create',[SlideController::class,'create']);
    Route::get('slide_show',[SlideController::class,'show']);
    Route::put('slide_update/{id}',[SlideController::class,'update']);
    Route::delete('slide_delete/{id}',[SlideController::class,'delete']);
    Route::post('brand_create',[ProductDetailsController::class,'createBrand']);
    Route::get('brand_show',[ProductDetailsController::class,'showBrand']);
    Route::put('brand_update/{id}',[ProductDetailsController::class,'updateBrand']);
    Route::delete('brand_delete/{id}',[ProductDetailsController::class,'deleteBrand']);
    Route::get('brand_show_by_id/{id}',[ProductDetailsController::class,'showBrandById']);
    Route::post('category_create',[ProductDetailsController::class,'createCategory']);
    Route::get('category_show',[ProductDetailsController::class,'showCategory']);
    Route::put('category_update/{id}',[ProductDetailsController::class,'updateCategory']);
    Route::delete('category_delete/{id}',[ProductDetailsController::class,'deleteCategory']);
    Route::get('category_show_by_id/{id}',[ProductDetailsController::class,'showCategoryById']);
    Route::post('color_create',[ProductDetailsController::class,'createColor']);
    Route::get('color_show',[ProductDetailsController::class,'showColor']);
    Route::put('color_update/{id}',[ProductDetailsController::class,'updateColor']);
    Route::delete('color_delete/{id}',[ProductDetailsController::class,'deleteColor']);
    Route::get('color_show_by_id/{id}',[ProductDetailsController::class,'getColorById']);
    Route::get('color_show_by_name/{name}',[ProductDetailsController::class,'getColorByName']);
    Route::post('product_create',[ProductController::class,'createProduct']);
    Route::get('product_show',[ProductController::class,'showProduct']);
    Route::put('product_update/{id}',[ProductController::class,'updateProduct']);
    Route::delete('product_delete/{id}',[ProductController::class,'deleteProduct']);
    Route::get('product_show_by_slug/{slug}',[ProductController::class,'showProductBySlug']);
    Route::get('product_show_by_id/{id}',[ProductController::class,'showProductById']);
    Route::put('product_update_stock/{id}',[ProductController::class,'updateStock']);
    Route::post('order_create',[OrderController::class,'orderCreate']);
    Route::get('order_last_user/{id}',[OrderController::class,'getLastOrderByUser']);
    Route::put('order_update/{id}',[OrderController::class,'updateOrder']);
    Route::get('order_show',[OrderController::class,'showOrder']);
    Route::get('order_details/{id}',[OrderController::class,'getOrderDetails']);
    Route::put('order_detail_update/{id}',[OrderController::class,'updateOrderDetail']);
    Route::get('order_user/{id}',[OrderController::class,'getOrderByUser']);
    Route::post('payment',[paymentController::class,'createPayment']);
    Route::post('payment_confirm',[paymentController::class,'confirmPayment']);
});
