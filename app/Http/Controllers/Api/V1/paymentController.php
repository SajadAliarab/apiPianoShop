<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class paymentController extends Controller
{
    /**
 * @OA\Post(
 *     path="/api/v1/payment",
 *     summary="Create a new payment",
 *     tags={"Payment"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="amount", type="integer", example=1000),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="string", example="pi_1J2K3K4L5M6N7O8P9Q0R"),
 *             @OA\Property(property="object", type="string", example="payment_intent"),
 *             @OA\Property(property="status", type="string", example="succeeded"),
 *             @OA\Property(property="amount", type="integer", example=1000),
 *             @OA\Property(property="currency", type="string", example="gbp"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Payment not created",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Payment Not Created")
 *         )
 *     )
 * )
 */
    public function createPayment(Request $request)
    {
        
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'gbp', 
                'payment_method' => 'pm_card_visa',
            ]);

            // Return client secret to frontend
            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'paymentId' => $paymentIntent->id],200);
        } catch (ApiErrorException $e) {
            // Handle error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *    path="/api/v1/payment_confirm",
     *   summary="Confirm a payment",
     *  tags={"Payment"},
     * @OA\RequestBody(
     *    required=true,
     *  @OA\JsonContent(
     *     @OA\Property(property="payment_intent_id", type="string", example="pi_1J2K3K4L5M6N7O8P9Q0R"),
     *  )
     * ),
     * @OA\Response(
     *   response=200,
     * description="Payment confirmed successfully",
     * @OA\JsonContent(
     *   @OA\Property(property="message", type="string", example="Payment confirmed successfully")
     * )
     * ),
     * @OA\Response(
     *  response=400,
     * description="Payment not confirmed",
     * @OA\JsonContent(
     *  @OA\Property(property="error", type="string", example="Payment Not Confirmed")
     * )
     * )
     * )
     */
    public function confirmPayment(Request $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Confirm the payment intent
            $test=$paymentIntent = PaymentIntent::retrieve($request->paymentIntentId,[]);
            $res=$paymentIntent->confirm([
                'payment_method' => 'pm_card_visa',
                'return_url' => 'http://localhost:3000/success',
              ]);

            // Payment confirmed successfully
            return response()->json([
                'message' => 'Payment confirmed successfully',
                'payment' => $res
            ],200);
        } catch (ApiErrorException $e) {
            // Handle error
            return response()->json([
                'message' => 'Payment Not Confirmed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

