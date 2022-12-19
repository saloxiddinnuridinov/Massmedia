<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostJoinFileResource;
use App\Models\PostJoinFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostJoinFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post-join-file",
     *      security={{"bearerAuth":{}}},
     *      operationId="PostJoinFile_index",
     *      tags={"PostJoinFile"},
     *      summary="All PostJoinFile",
     *      description="Hamma PostJoinFilelarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *       @OA\JsonContent(ref="#/components/schemas/PostJoinFile"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *     )
     */
    public function index()
    {
        return PostJoinFileResource::collection(PostJoinFile::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/post-join-file",
     *      security={{"bearerAuth":{}}},
     *      operationId="PostJoinFile_store",
     *      tags={"PostJoinFile"},
     *      summary="new PostJoinFile add",
     *      description="Yangi PostJoinFile qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"post_id", "file_id"},
     *                  @OA\Property(property="post_id", type="number", format="integer", example="1"),
     *                  @OA\Property(property="file_id", type="number", format="integer", example="1"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PostJoinFile"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function store(Request $request)
    {
        $rules = [
           'post_id' => 'required',
           'file_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new PostJoinFile();
            $model->post_id = $request->post_id;
            $model->file_id = $request->file_id;
            $model->save();
            return response()->json(new PostJoinFileResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/post-join-file/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show PostJoinFile",
     * description="bitta PostJoinFile hamma malumotlarini korsatadi",
     * operationId="PostJoinFile_show",
     * tags={"PostJoinFile"},
     * @OA\Parameter(
     *    name="id",
     *    description="id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer"
     *    )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PostJoinFile"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
 
    public function show($id)
    {
        $model = PostJoinFile::find($id);
        if($model){
            try {
                return new PostJoinFileResource($model);
                }catch (\Throwable $th) {
                    return response()->json([
                        "errors" =>["$th"],
                    ], 403);
                }
            }
            return response()->json(['errors' => ['Not found']], 404);
    }

    public function edit(Request $request)
    {
        //
    }
    /**
     * @OA\Put(
     *      path="/api/v1/post-join-file/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="PostJoinFile_update",
     *      tags={"PostJoinFile"},
     *      summary="Update existing project",
     *      description="Returns updated project data",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Category",
     *          @OA\JsonContent(required={"post_id", "file_id"},
     *               @OA\Property(property="post_id", type="number", example="1"),
     *               @OA\Property(property="file_id", type="number", example="1"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/PostJoinFile"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * ),
     * ),
     * )
     */

    public function update(Request $request, $id)
    {
        $rules = [
            'post_id' => 'required',
            'file_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = PostJoinFile::find($id);
            if ($model){
                $model->update([
                    'post_id' => $request->post_id,
                    'file_id' => $request->file_id,
                ]);
                return response()->json(
                    new PostJoinFileResource($model), 
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/post-join-file/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="PostJoinFile_delete",
     *      tags={"PostJoinFile"},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PostJoinFile"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function destroy($id)
    {
        $model = PostJoinFile::find($id);
        if($model){
            try {
                $model->delete();
                return response()->json([
                    'message' => "O`chirildi", 
                    ],200);
                }catch (\Throwable $th) {
                    return response()->json([
                        "errors" =>["$th"],
                    ], 403);
                }
            }
            return response()->json(['errors' => ['Not found']], 404);
    }

}