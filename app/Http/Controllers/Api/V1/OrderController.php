<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/order_create",
     *     summary="Order Add",
     *     description="Process order for the items in the request",
     *     tags={"Order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            @OA\Property(property="userId", type="integer"),
     *             @OA\Property(property="items", type="array", @OA\Items(
     *                 @OA\Property(property="product", type="integer"),
     *                 @OA\Property(property="quantity", type="integer"),
     *                @OA\Property(property="color", type="string"),
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment processed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="total_price", type="number"),
     *             @OA\Property(property="delivery_code", type="integer"),
     *             @OA\Property(property="payment_status", type="string"),
     *             @OA\Property(property="transaction_id", type="string"),
     *             @OA\Property(property="shipping_method", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="order_date", type="string", format="date-time"),
     *             @OA\Property(property="delivery_date", type="string", format="date-time"),
     *             @OA\Property(property="order_details", type="array", @OA\Items(
     *                 @OA\Property(property="order_id", type="integer"),
     *                 @OA\Property(property="product", type="integer"),
     *                @OA\Property(property="color", type="string"),
     *                 @OA\Property(property="quantity", type="integer"),
     *                 @OA\Property(property="price", type="number"),
     *                 @OA\Property(property="discount", type="number"),
     *                 @OA\Property(property="total_price", type="number"),
     *                 @OA\Property(property="order_status", type="string")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function orderCreate(Request $request){
        $total_price =0;

       foreach($request->items as $item){
       $product = Product::find($item['product']);
       if($product->discount == 0){
           $total_price += $product->price * $item['quantity'];
       } else{
              $total_price += ($product->price-$product->discount) * $item['quantity'];
       }
    }
    $order= Order::create([
        'total_price' => $total_price,
        'delivery_code'=> rand(1000,9999),
        'payment_status'=> 'pending',
        'transaction_id'=> '0',
        'shipping_method'=> '0',
        'user_id'=> $request->userId,
        'order_date'=> now(),
        'delivery_date'=> now()->addDays(7),

    ]);
    foreach($request->items as $item){
        $product = Product::find($item['product']);
        $orderdetail=OrderDetail::create([
            'order_id'=> $order->id,
            'product'=> $item['product'],
            'color'=> $item['color'],
            'quantity'=> $item['quantity'],
            'price'=> $product->price,
            'discount'=> $product->discount,
            'total_price'=> ($product->price-$product->discount)*$item['quantity'],
            'order_status'=> 'pending',
        ]);
    }
}

/**
 * @OA\Get(
 *     path="/api/v1/order_last_user/{id}",
 *     summary="Get Order by ID",
 *     description="Get order by ID",
 *     tags={"Order"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of order to return",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *        response=200,
 *       description="Order found",
 *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *  ),
 *     @OA\Response(
 *         response=404,
 *         description="Order not found"
 *     )
 * )
 */
public function getLastOrderByUser($id){
    $order =Order::where('user_id', $id)->orderBy('id', 'desc')->first();
    if($order){
        return response()->json(['result'=>true,
        'message' => 'Order found',
        'data'=> $order
      ], 200);
    } else{
        return response()->json(['result'=>false,
        'message' => 'Order not found',
      ], 404);
    }

}

/**
 * @OA\Put(
 *     path="/api/v1/order_update/{id}",
 *     summary="Update Order",
 *     description="Update order by ID",
 *     tags={"Order"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of order to update",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *            @OA\Property(property="total_price", type="number"),
 *             @OA\Property(property="delivery_code", type="integer"),
 *             @OA\Property(property="payment_status", type="string"),
 *             @OA\Property(property="transaction_id", type="string"),
 *             @OA\Property(property="shipping_method", type="string"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="order_date", type="string", format="date-time"),
 *             @OA\Property(property="delivery_date", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated",
 *         @OA\JsonContent(
 *             @OA\Property(property="result", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Order not found"
 *     )
 * )
 */

public function updateOrder(Request $request, $id){
    $order = Order::find($id);#
    if(!$order){
        return response()->json(['result'=>false,
        'message' => 'Order not found',
      ], 404);
    }else{
    $order->update($request->all());
    return response()->json(['result'=>true,
    'message' => 'Order updated'],200);
    }

}


/**
 * @OA\Get(
 *     path="/api/v1/order_show",
 *     summary="Get Orders",
 *     description="Get all orders",
 *     tags={"Order"},
 *     @OA\Response(
 *        response=200,
 *       description="Orders found",
 *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *  ),
 *     @OA\Response(
 *         response=404,
 *         description="Orders not found"
 *     )
 * )
 */
public function showOrder(){
    $orders = Order::with('orderDetails')->get();

    if ($orders->isNotEmpty()) {
        return response()->json([
            'result' => true,
            'message' => 'Orders found',
            'data' => $orders
        ], 200);
    } else {
        return response()->json([
            'result' => false,
            'message' => 'Orders not found'
        ], 404);
    }
}

/**
 * @OA\Get(
 *     path="/api/v1/order_details/{id}",
 *     summary="Get Order Details",
 *     description="Get order details by order ID",
 *     tags={"Order"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of order to return details",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *        response=200,
 *       description="Order details found",
 *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *  ),
 *     @OA\Response(
 *         response=404,
 *         description="Order details not found"
 *     )
 * )
 */

public function getOrderDetails($id){
   $orderdetails = OrderDetail::where('order_id', $id)->get();
    if($orderdetails->isNotEmpty()){
         return response()->json([
              'result' => true,
              'message' => 'Order details found',
              'data' => $orderdetails
         ], 200);
    } else{
         return response()->json([
              'result' => false,
              'message' => 'Order details not found'
         ], 404);
    }
}

/**
 * @OA\Put(
 *     path="/api/v1/order_detail_update/{id}",
 *     summary="Update Order Detail",
 *     description="Update order detail by ID",
 *     tags={"Order"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of order detail to update",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *            @OA\Property(property="order_id", type="integer"),
 *             @OA\Property(property="product", type="integer"),
 *             @OA\Property(property="color", type="string"),
 *             @OA\Property(property="quantity", type="integer"),
 *             @OA\Property(property="price", type="number"),
 *             @OA\Property(property="discount", type="number"),
 *             @OA\Property(property="total_price", type="number"),
 *             @OA\Property(property="order_status", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order detail updated",
 *         @OA\JsonContent(
 *             @OA\Property(property="result", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Order detail not found"
 *     )
 * )
 */
public function updateOrderDetail(Request $request, $id){
    $orderdetail = OrderDetail::find($id);
    if(!$orderdetail){
        return response()->json(['result'=>false,
        'message' => 'Order detail not found',
      ], 404);
    }else{
    $orderdetail->update($request->all());
    return response()->json(['result'=>true,
    'message' => 'Order detail updated'],200);
    }
}

/**
 * @OA\Get(
 *     path="/api/v1/order_user/{id}",
 *     summary="Get Order by User",
 *     description="Get order by user ID",
 *     tags={"Order"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of user to return orders",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *        response=200,
 *       description="Orders found",
 *      @OA\MediaType(
   *           mediaType="application/json",
   *      )
   *  ),
 *     @OA\Response(
 *         response=404,
 *         description="Orders not found"
 *     )
 * )
 */
public function getOrderByUser($id){
    $orders = Order::where('user_id', $id)->get();
    if($orders->isNotEmpty()){
        return response()->json([
            'result' => true,
            'message' => 'Orders found',
            'data' => $orders
        ], 200);
    } else{
        return response()->json([
            'result' => false,
            'message' => 'Orders not found'
        ], 404);
    }
}
}
