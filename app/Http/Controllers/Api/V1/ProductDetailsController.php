<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Http\Resources\ProductDetailsResource;
class ProductDetailsController extends Controller
{
  
    /**
   * @OA\Post(
   ** path="/api/v1/brand_create",
   *  tags={"Product Details Api"},
   *  description="use for insert brand to database",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="name",
   *                  description="Enter Brand Name",
   *                  type="string",),
   *           @OA\Property(
   *                  property="image",
   *                  description="Enter Brand Image Name",
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
    public function createBrand (Request $request){
        if($request != null){
            $name = $request->input('name');
            $image = $request->input('image');
            Brand::create([
                'name'=>$name,
                'image'=>$image
            ]);
            return response()->json([
                'result'=>true,
                'message'=>'Brand Created Successfully'
            ],200);
        }else{
            return response()->json([
                'result'=>false,
                'message'=>'Brand Not Created'
            ],400);
        }
    }
    /**
        * @OA\Get(
        ** path="/api/v1/brand_show",
        *  tags={"Product Details Api"},
        *  description="use for get all brands",
        *   @OA\Response(
        *      response=200,
        *      description="Success",
        *      @OA\MediaType(
        *           mediaType="application/json",
        *      )
        *   )
        *)
        **/

public function showBrand(){
    $brand = ProductDetailsResource::collection(Brand::all()->keyBy->id);
    return Response()->json([
        'result' => true,
        'message'=> "you have access to slides",
        'data'=>[
          $brand
        ],
      ],200);
    }
           /**
          * @OA\Put(
          ** path="/api/v1/brand_update/{id}",
          *  tags={"Product Details Api"},
          *  description="use for update brand information",
          * @OA\Parameter(
          *         name="id",
          *         in="path",
          *         description="Brand ID",
          *         required=true,
          *         @OA\Schema(
          *             type="integer"
          *         )
          *     ),
          * @OA\RequestBody(
          *    required=true,
          * *         @OA\MediaType(
          *           mediaType="multipart/form-data",
          *           @OA\Schema(
          *           @OA\Property(
          *                  property="name",
          *                  description="Enter brand Name",
          *                  type="string",),
          *           @OA\Property(
          *                  property="image",
          *                  description="Enter brand Image Name",
          *                  type="string",),
          *     )
          *   )
          * ),
          *   @OA\Response(
          *      response=200,
          *      description="Brand updated successfully",
          *      @OA\MediaType(
          *           mediaType="application/json",
          *      )
          *   ),
          *   @OA\Response(
          *      response=404,
          *      description="Brand not found",
          *      @OA\MediaType(
          *           mediaType="application/json",
          *      )
          *   )
          *)
          **/
    public function updateBrand(Request $request,$id){
        $brand = Brand::find($id);
        if($brand!=null){
            $brand->name = $request->input('name');
            $brand->image = $request->input('image');
        $brand->save();
        return response()->json([
            'result'=>true,
            'message'=>'Brand Updated Successfully'
        ],200);
    }else{
        return response()->json([
            'result'=>false,
            'message'=>'Brand Not Found'
        ],400);
    }
    }
    /**
        * @OA\Delete(
        ** path="/api/v1/brand_delete/{id}",
        *  tags={"Product Details Api"},
        *  description="use for delete brand from database",
          * @OA\Parameter(
          *         name="id",
          *         in="path",
          *         description="Brand ID",
          *         required=true,
          *         @OA\Schema(
          *             type="integer"
          *         )
          *     ),
 
        *   @OA\Response(
        *      response=200,
        *      description="Its Ok",
        *      @OA\MediaType(
        *           mediaType="application/json",
        *      )
        *   )
        *)
        **/
    Public function deleteBrand($id){
        $brand = Brand::find($id);
        if($brand!=null){
            $brand->delete();
            return response()->json([
                'result'=>true,
                'message'=>'Brand Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'result'=>false,
                'message'=>'Brand Not Found'
            ],400);
        }
    }

    /**
     * @OA\Get(
     ** path="/api/v1/brand_show_by_id/{id}",
     *  tags={"Product Details Api"},
     *  description="use for get brand by id",
     * @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Brand ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Brand not found",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/

    public function showBrandById($id){
        $brand = Brand::find($id);
        if($brand!=null){
            return response()->json([
                'result'=>true,
                'message'=>'Brand Found',
                'data'=>[
                    $brand
                ]
            ],200);
        }else{
            return response()->json([
                'result'=>false,
                'message'=>'Brand Not Found'
            ],400);
        }
    }
     /**
   * @OA\Post(
   ** path="/api/v1/category_create",
   *  tags={"Product Details Api"},
   *  description="use for insert category to database",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="name",
   *                  description="Enter Brand Name",
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
  public function createCategory (Request $request){
    if($request != null){
        $name = $request->input('name');
        Category::create([
            'name'=>$name,
        ]);
        return response()->json([
            'result'=>true,
            'message'=>'Category Created Successfully'
        ],200);
    }else{
        return response()->json([
            'result'=>false,
            'message'=>'Category Not Created'
        ],400);
    }
}
/**
    * @OA\Get(
    ** path="/api/v1/category_show",
    *  tags={"Product Details Api"},
    *  description="use for get all categories",
    *   @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *   )
    *)
    **/
    public function showCategory(){
        $category = Category::all();
        return Response()->json([
            'result' => true,
            'message'=> "you have access to categories",
            'data'=>[
              $category
            ],
          ],200);
        }
              /**
             * @OA\Put(
             ** path="/api/v1/category_update/{id}",
             *  tags={"Product Details Api"},
             *  description="use for update category information",
             * @OA\Parameter(
             *         name="id",
             *         in="path",
             *         description="Category ID",
             *         required=true,
             *         @OA\Schema(
             *             type="integer"
             *         )
             *     ),
             * @OA\RequestBody(
             *    required=true,
             * *         @OA\MediaType(
             *           mediaType="multipart/form-data",
             *           @OA\Schema(
             *           @OA\Property(
             *                  property="name",
             *                  description="Enter category Name",
             *                  type="string",),
             *     )
             *   )
             * ),
             *   @OA\Response(
             *      response=200,
             *      description="Category updated successfully",
             *      @OA\MediaType(
             *           mediaType="application/json",
             *      )
             *   ),
             *   @OA\Response(
             *      response=404,
             *      description="Category not found",
             *      @OA\MediaType(
             *           mediaType="application/json",
             *      )
             *   )
             *)
             **/
        public function updateCategory(Request $request,$id){
            $category = Category::find($id);
            if($category!=null){
                $category->name = $request->input('name');
            $category->save();
            return response()->json([
                'result'=>true,
                'message'=>'Category Updated Successfully'
            ],200);
        }else{
            return response()->json([
                'result'=>false,
                'message'=>'Category Not Found'
            ],400);
        }
        }
        /**
            * @OA\Delete(
            ** path="/api/v1/category_delete/{id}",
            *  tags={"Product Details Api"},
            *  description="use for delete category from database",
              * @OA\Parameter(
              *         name="id",
              *         in="path",
              *         description="Category ID",
              *         required=true,
              *         @OA\Schema(
              *             type="integer"
              *         )
              *     ),
     
            *   @OA\Response(
            *      response=200,
            *      description="Its Ok",
            *      @OA\MediaType(
            *           mediaType="application/json",
            *      )
            *   )
            *)
            **/
        Public function deleteCategory($id){
            $category = Category::find($id);
            if($category!=null){
                $category->delete();
                return response()->json([
                    'result'=>true,
                    'message'=>'Category Deleted Successfully'
                ],200);
            }else{
                return response()->json([
                    'result'=>false,
                    'message'=>'Category Not Found'
                ],400);
            }
        }

        /**
         * @OA\Get(
         ** path="/api/v1/category_show_by_id/{id}",
         *  tags={"Product Details Api"},
         *  description="use for get category by id",
         * @OA\Parameter(
         *         name="id",
         *         in="path",
         *         description="Category ID",
         *         required=true,
         *         @OA\Schema(
         *             type="integer"
         *         )
         *     ),
         *   @OA\Response(
         *      response=200,
         *      description="Success",
         *      @OA\MediaType(
         *           mediaType="application/json",
         *      )
         *   ),
         *   @OA\Response(
         *      response=404,
         *      description="Category not found",
         *      @OA\MediaType(
         *           mediaType="application/json",
         *      )
         *   )
         *)
         **/

        public function showCategoryById($id){
            $category = Category::find($id);
            if($category!=null){
                return response()->json([
                    'result'=>true,
                    'message'=>'Category Found',
                    'data'=>[
                        $category
                    ]
                ],200);
            }else{
                return response()->json([
                    'result'=>false,
                    'message'=>'Category Not Found'
                ],400);
            }
        }
        /**
         * @OA\Post(
         * path="/api/v1/color_create",
         * tags={"Product Details Api"},
         * description="use for insert color to database",
         * @OA\RequestBody(
         *   required=true,
         * *         @OA\MediaType(
         *          mediaType="multipart/form-data",
         *         @OA\Schema(
         *        @OA\Property(
         *              property="name",
         *             description="Enter Color Name",
         *            type="string",),
         *       @OA\Property(
         *             property="image",
         *           description="Enter Color Image Name",
         *         type="string",),
         *  )
         * )
         * ),
         *  @OA\Response(
         *   response=200,
         *  description="Its Ok",
         * @OA\MediaType(
         *     mediaType="application/json",
         * )
         * )
         * )
         */
        public function createColor (Request $request){
            if($request != null){
                $name = $request->input('name');
                $image = $request->input('image');
                Color::create([
                    'name'=>$name,
                    'image'=>$image
                ]);
                return response()->json([
                    'result'=>true,
                    'message'=>'Color Created Successfully'
                ],200);
            }else{
                return response()->json([
                    'result'=>false,
                    'message'=>'Color Not Created'
                ],400);
            }
        }
        /**
            * @OA\Get(
            ** path="/api/v1/color_show",
            *  tags={"Product Details Api"},
            *  description="use for get all colors",
            *   @OA\Response(
            *      response=200,
            *      description="Success",
            *      @OA\MediaType(
            *           mediaType="application/json",
            *      )
            *   )
            *)
            **/ 
            public function showColor(){
                $color = ProductDetailsResource::collection(Color::all()->keyBy->id);
                return Response()->json([
                    'result' => true,
                    'message'=> "you have access to slides",
                    'data'=>[
                      $color
                    ],
                  ],200);
                }
                  /**
                 * @OA\Put(
                 ** path="/api/v1/color_update/{id}",
                 *  tags={"Product Details Api"},
                 *  description="use for update color information",
                 * @OA\Parameter(
                 *         name="id",
                 *         in="path",
                 *         description="Color ID",
                 *         required=true,
                 *         @OA\Schema(
                 *             type="integer"
                 *         )
                 *     ),
                 * @OA\RequestBody(
                 *    required=true,
                 * *         @OA\MediaType(
                 *           mediaType="multipart/form-data",
                 *           @OA\Schema(
                 *           @OA\Property(
                 *                  property="name",
                 *                  description="Enter color Name",
                 *                  type="string",),
                 *           @OA\Property(
                 *                  property="image",
                 *                  description="Enter color Image Name",
                 *                  type="string",),
                 *     )
                 *   )
                 * ),
                 *   @OA\Response(
                 *      response=200,
                 *      description="Color updated successfully",
                 *      @OA\MediaType(
                 *           mediaType="application/json",
                 *      )
                 *   ),
                 *   @OA\Response(
                 *      response=404,
                 *      description="Color not found",
                 *      @OA\MediaType(
                 *           mediaType="application/json",
                 *      )
                 *   )
                 *)
                 **/
            public function updateColor(Request $request,$id){
                $color = Color::find($id);
                if($color!=null){
                    $color->name = $request->input('name');
                    $color->image = $request->input('image');
                $color->save();
                return response()->json([
                    'result'=>true,
                    'message'=>'Color Updated Successfully'
                ],200);
            }else{
                return response()->json([
                    'result'=>false,
                    'message'=>'Color Not Found'
                ],400);
            }
            }
            /**
                * @OA\Delete(
                ** path="/api/v1/color_delete/{id}",
                *  tags={"Product Details Api"},
                *  description="use for delete color from database",
                  * @OA\Parameter(
                  *         name="id",
                  *         in="path",
                  *         description="Color ID",
                  *         required=true,
                  *         @OA\Schema(
                  *             type="integer"
                  *         )
                  *     ),
                  *   @OA\Response(
                  *      response=200,
                  *      description="Its Ok",
                  *      @OA\MediaType(
                  *           mediaType="application/json",
                  *      )
                  *   )
                  *)
                 **/
            Public function deleteColor($id){  
                $color = Color::find($id);
                if($color!=null){
                    $color->delete();
                    return response()->json([
                        'result'=>true,
                        'message'=>'Color Deleted Successfully'
                    ],200);
                }else{
                    return response()->json([
                        'result'=>false,
                        'message'=>'Color Not Found'
                    ],400);
                }
            }

            /**
             * @OA\Get(
             ** path="/api/v1/color_show_by_id/{id}",
             *  tags={"Product Details Api"},
             *  description="use for get color by id",
             * @OA\Parameter(
             *         name="id",
             *         in="path",
             *         description="Color ID",
             *         required=true,
             *         @OA\Schema(
             *             type="integer"
             *         )
             *     ),
             *   @OA\Response(
             *      response=200,
             *      description="Success",
             *      @OA\MediaType(
             *           mediaType="application/json",
             *      )
             *   ),
             *   @OA\Response(
             *      response=404,
             *      description="Color not found",
             *      @OA\MediaType(
             *           mediaType="application/json",
             *      )
             *   )
             *)
             **/
            public function getColorById($id){
                $color = Color::find($id);
                if($color!=null){
                    return response()->json([
                        'result'=>true,
                        'message'=>'Color Found',
                        'data'=>[
                            $color
                        ]
                    ],200);
                }else{
                    return response()->json([
                        'result'=>false,
                        'message'=>'Color Not Found'
                    ],400);
                }
            }
            /**
             * @OA\Get(
             ** path="/api/v1/color_show_by_name/{name}",
             *  tags={"Product Details Api"},
             *  description="use for get color by name",
             * @OA\Parameter(
             *         name="name",
             *         in="path",
             *         description="Color Name",
             *         required=true,
             *         @OA\Schema(
             *             type="string"
             *         )
             *     ),
             *   @OA\Response(
             *      response=200,
             *      description="Success",
             *      @OA\MediaType(
             *           mediaType="application/json",
             *      )
             *   ),
             *   @OA\Response(
             *      response=404,
             *      description="Color not found",
             *      @OA\MediaType(
             *           mediaType="application/json",
             *      )
             *   )
             *)
             **/

            public function getColorByName($name){
                $color = Color::where('name',$name)->get();
                if($color!=null){
                    return response()->json([
                        'result'=>true,
                        'message'=>'Color Found',
                        'data'=>[
                            $color[0]->image
                        ]
                    ],200);
                }else{
                    return response()->json([
                        'result'=>false,
                        'message'=>'Color Not Found'
                    ],400);
                }
            }
}
