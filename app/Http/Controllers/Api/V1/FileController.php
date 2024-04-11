<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
   * @OA\Post(
   ** path="/api/v1/upload_file",
   *  tags={"Upload File Api"},
   *  description="use for upload a file to public folder",
   * @OA\RequestBody(
   *    required=true,
   * *         @OA\MediaType(
   *           mediaType="multipart/form-data",
   *           @OA\Schema(
   *           @OA\Property(
   *                  property="file",
   *                  description="add your file",
   *                  type="file",),
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
class FileController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); 
            return response()->json([
                'result' => true,
                'message' => 'File uploaded successfully', 
                'file' => $fileName],200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'No file uploaded'
            ], 400);
        }
    }

    /**
        * @OA\Delete(
        ** path="/api/v1/delete_file/{fileName}",
        *  tags={"Upload File Api"},
        *  description="use for delete a file from public folder",
        * @OA\Parameter(
        *    name="fileName",
        *    in="path",
        *    description="The name of the file to delete",
        *    required=true,
        *    @OA\Schema(
        *        type="string"
        *    )
        * ),
        *   @OA\Response(
        *      response=200,
        *      description="File deleted successfully",
        *      @OA\MediaType(
        *           mediaType="application/json",
        *      )
        *   ),
        *   @OA\Response(
        *      response=404,
        *      description="File not found",
        *      @OA\MediaType(
        *           mediaType="application/json",
        *      )
        *   )
        *)
        **/
    public function deleteFile($fileName)
    {
        $filePath = public_path('uploads') . '/' . $fileName;
        
        if (file_exists($filePath)) {
            unlink($filePath);
            return response()->json([
                'result' => true,
                'message' => 'File deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'File not found'
            ], 404);
        }
    }
}
