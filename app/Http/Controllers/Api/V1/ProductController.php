<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductsResource;

class ProductController extends Controller
{
     /**
   * @OA\Post(
   ** path="/api/v1/product_create",
   *  tags={"Product Api"},
   *  description="use for insert product to database",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="title",
   *                 type="string",
   *                description="Title of the product"
   *           ),
   *          @OA\Property(
   *                 property="slug",
   *                type="string",
   *               description="Slug of the product"
   *         ),
   *        @OA\Property(
   *              property="price",
   *            type="float",
   *          description="Price of the product"
   *      ),
   *    @OA\Property(
   *         property="reviews",
   *       type="integer",
   *    description="Reviews of the product"
   * ),
   * @OA\Property(
   *     property="rating",
   *   type="float",
   * description="Rating of the product"
   * ),
   * @OA\Property(
   *    property="stock",
   * type="integer",
   * description="Stock of the product"
   * ),
   * @OA\Property(
   *   property="image",
   * type="string",
   * description="Image of the product"
   * ),
   * @OA\Property(
   * property="discount",
   * type="float",
   * description="Discount of the product"
   * ),
   * @OA\Property(
   * property="description",
   * type="text",
   * description="Description of the product"
   * ), 
   * @OA\Property(
   * property="status",
   * type="string",
   * description="Status of the product"
   * ),
   * @OA\Property(
   * property="brand_id",
   * type="integer",
   * description="Brand id of the product"
   * ),
   * @OA\Property(
   * property="category_id",
   * type="integer",
   * description="Category id of the product"
   *),
    * @OA\Property(
    * property="color_id",
    * type="array",
    * @OA\Items(
    * type="integer",
    * description="Color id of the product"
    * )
    * ),
   * 
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
   public function createProduct(Request $request){
        if($request!=null){
            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->reviews = $request->reviews;
            $product->rating = $request->rating;
            $product->stock = $request->stock;
            $product->image = $request->image;
            $product->discount = $request->discount;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->save();
            //add to table color_product
            $product->colors()->attach($request->colors);
            return response()->json([
                'result' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ], 200);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Product not created'
            ], 400);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/product_show",
     * tags={"Product Api"},
     * description="use for show product from database",
     * @OA\Response(
     * response=200,
     * description="Its Ok",
     * @OA\MediaType(
     * mediaType="application/json",
     * )
     * )
     * )
     */

    public function showProduct(){
        $product = ProductsResource::collection(Product::all()->keyBy->id);
        return response()->json([
            'result' => true,
            'message' => 'Product show successfully',
            'data' => $product
        ], 200);
    }


    /**
     * @OA\Put(
     * path="/api/v1/product_update/{id}",
     * tags={"Product Api"},
     * description="use for update product to database",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of the product",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\RequestBody(
     *   required=true,
     *  @OA\MediaType(
     *   mediaType="multipart/form-data",
     *  @OA\Schema(
     * @OA\Property(
     * property="title",
     * type="string",
     * description="Title of the product"
     * ),
     * @OA\Property(
     * property="slug",
     * type="string",
     * description="Slug of the product"
     * ),
     * @OA\Property(
     * property="price",
     * type="float",
     * description="Price of the product"
     * ),
     * @OA\Property(
     * property="reviews",
     * type="integer",
     *  description="Reviews of the product"
     * ),
     * @OA\Property(
     * property="rating",
     * type="float",
     * description="Rating of the product"
     * ),
     * @OA\Property(
     * property="stock",
     * type="integer",
     * description="Stock of the product"
     * ),
     * @OA\Property(
     * property="image",
     * type="string",
     * description="Image of the product"
     * ),
     * @OA\Property(
     * property="discount",
     * type="float",
     * description="Discount of the product"
     * ),
     * @OA\Property(
     * property="description",
     * type="text",
     * description="Description of the product"
     * ),
     * @OA\Property(
     * property="status",
     * type="string",
     * description="Status of the product"
     * ),
     * @OA\Property(
     * property="brand_id",
     * type="integer",
     * description="Brand id of the product"
     * ),
     * @OA\Property(
     * property="category_id",
     * type="integer",
     * description="Category id of the product"
     * ),
     *  )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Its Ok",
     * @OA\MediaType(
     * mediaType="application/json",
     * )
     * )
     * )
     */
    public function updateProduct(Request $request, $id){
        
            $product = Product::find($id);
            if($product!=null){
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->reviews = $request->reviews;
            $product->rating = $request->rating;
            $product->stock = $request->stock;
            $product->image = $request->image;
            $product->discount = $request->discount;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->save();
            //update table color_product
            $product->colors()->sync($request->colors);
            return response()->json([
                'result' => true,
                'message' => 'Product updated successfully'
            ], 200);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Product not updated'
            ], 400);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/v1/product_delete/{id}",
     * tags={"Product Api"},
     * description="use for delete product from database",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of the product",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Its Ok",
     * @OA\MediaType(
     * mediaType="application/json",
     * )
     * )
     * )
     */
    public function deleteProduct($id){
        $product = Product::find($id);
        if($product!=null){
            $product->delete();
            //delete from table color_product
            $product->colors()->detach();
            return response()->json([
                'result' => true,
                'message' => 'Product deleted successfully'
            ], 200);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Product not deleted'
            ], 400);
        }
    }

    /**
     * @OA\Get(
     * path="/api/v1/product_show_by_slug/{slug}",
     * tags={"Product Api"},
     * description="use for show product by slug from database",
     * @OA\Parameter(
     * name="slug",
     * in="path",
     * description="ID of the product",
     * required=true,
     * @OA\Schema(
     * type="string"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Its Ok",
     * @OA\MediaType(
     * mediaType="application/json",
     * )
     * )
     * )
     */
    public function showProductBySlug($slug){
        $product = Product::where('slug', $slug)->first();
        if($product!=null){
            $colors = $product->colors()->get();
            return response()->json([
                'result' => true,
                'message' => 'Product show successfully',
                'data' => $product,
                'colors' => $colors
            ], 200);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Product not found'
            ], 400);
        }
    }

    /**
     * @OA\Get(
     * path="/api/v1/product_show_by_id/{id}",
     * tags={"Product Api"},
     * description="use for show product by id from database",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of the product",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Its Ok",
     * @OA\MediaType(
     * mediaType="application/json",
     * )
     * )
     * )
     */
    public function showProductById($id){
        $product = Product::find($id);
        if($product!=null){
            $colors = $product->colors()->get();
            return response()->json([
                'result' => true,
                'message' => 'Product show successfully',
                'data' => $product,
                'colors' => $colors
            ], 200);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Product not found'
            ], 400);
        }
    }

    /**
     * @OA\Put(
     * path="/api/v1/product_update_stock/{id}",
     * tags={"Product Api"},
     * description="use for update stock of product",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of the product",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(
     * @OA\Property(
     * property="stock",
     * type="integer",
     * description="Stock of the product"
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Its Ok",
     * @OA\MediaType(
     * mediaType="application/json",
     * )
     * )
     * )
     */
    public function updateStock(Request $request,$id){
        $product = Product::find($id);
        if($product!=null){
            $product->stock = $request->stock;
            $product->save();
            return response()->json([
                'result' => true,
                'message' => 'Stock updated successfully'
            ], 200);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Stock not updated'
            ], 400);
        }
    }
}
