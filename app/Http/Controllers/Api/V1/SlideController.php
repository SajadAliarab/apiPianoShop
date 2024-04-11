<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Http\Resources\SlidesResource;


class SlideController extends Controller
{


    /**
   * @OA\Post(
   ** path="/api/v1/slide_create",
   *  tags={"Slide Api"},
   *  description="use for insert slide to database",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="title",
   *                  description="Enter image title",
   *                  type="string",),
   *           @OA\Property(
   *                  property="link",
   *                  description="Enter your link",
   *                  type="link",),
   *           @OA\Property(
   *                  property="file",
   *                  description="add your file",
   *                  type="file",
   *               ),
   *           @OA\Property(
   *                  property="alt",
   *                  description="image alt",
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
    public function create(Request $request)
    {
        if ($request != null) {
            $title = $request->input('title');
            $link = $request->input('link');
            $file = $request->input('file');
            $alt = $request->input('alt');
            Slide::query()->create([
              'title' => $title,
              'link' => $link,
              'file' => $file,
              'alt' => $alt
            ]);
      
            return Response()->json([
              'result' => true,
              'message' => "slide have inserted",
            ], 200);
          } else {
            return Response()->json([
              'result' => false,
              'message' => "access denied",
            ], 403);
          }
        }
/**
   * @OA\Get(
   ** path="/api/v1/slide_show",
   *  tags={"Slide Api"},
   *  description="use for get slide information",
   * @OA\RequestBody(
  
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
    public function show(){
      $slider =  SlidesResource::collection(Slide::all()->keyBy->id);
          return Response()->json([
            'result' => true,
            'message'=> "you have access to slides",
            'data'=>[
              $slider
            ],
          ],200);
        }
    

        /**
          * @OA\Delete(
          ** path="/api/v1/slide_delete/{id}",
          *  tags={"Slide Api"},
          *  description="use for delete slide from database",
          * @OA\Parameter(
          *         name="id",
          *         in="path",
          *         description="Slide ID",
          *         required=true,
          *         @OA\Schema(
          *             type="integer"
          *         )
          *     ),
          *   @OA\Response(
          *      response=200,
          *      description="Slide deleted successfully",
          *      @OA\MediaType(
          *           mediaType="application/json",
          *      )
          *   ),
          *   @OA\Response(
          *      response=404,
          *      description="Slide not found",
          *      @OA\MediaType(
          *           mediaType="application/json",
          *      )
          *   )
          *)
          **/
          public function delete($id) {
            $slide = Slide::find($id);
        
            if (!$slide) {
                return response()->json([
                    'result' => false,
                    'message' => "Slide not found",
                ], 404);
            }
        
            $slide->delete();
        
            return response()->json([
                'result' => true,
                'message' => "Slide deleted successfully",
            ], 200);
        }

        /**
          * @OA\Put(
          ** path="/api/v1/slide_update/{id}",
          *  tags={"Slide Api"},
          *  description="use for update slide information",
          * @OA\Parameter(
          *         name="id",
          *         in="path",
          *         description="Slide ID",
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
          *                  property="title",
          *                  description="Enter image title",
          *                  type="string",),
          *           @OA\Property(
          *                  property="link",
          *                  description="Enter your link",
          *                  type="link",),
          *           @OA\Property(
          *                  property="file",
          *                  description="add your file",
          *                  type="string",
          *               ),
          *           @OA\Property(
          *                  property="alt",
          *                  description="image alt",
          *                  type="string",
          *               ),
          *     )
          *   )
          * ),
          *   @OA\Response(
          *      response=200,
          *      description="Slide updated successfully",
          *      @OA\MediaType(
          *           mediaType="application/json",
          *      )
          *   ),
          *   @OA\Response(
          *      response=404,
          *      description="Slide not found",
          *      @OA\MediaType(
          *           mediaType="application/json",
          *      )
          *   )
          *)
          **/
        public function update(Request $request, $id) {
          $slide = Slide::find($id);
      
          if ($slide) {
            $slide->title = $request->input('title');
            $slide->link = $request->input('link');
            $slide->file = $request->input('file');
            $slide->alt = $request->input('alt');
        
            $slide->save();
      
            return Response()->json([
              'result' => true,
              'message' => "slide have inserted",
            ], 200);
          } else {
            return Response()->json([
              'result' => false,
              'message' => "access denied",
            ], 404);
          }
        }
        
  }