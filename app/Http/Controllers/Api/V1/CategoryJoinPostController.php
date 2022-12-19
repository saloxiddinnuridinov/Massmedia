<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryJoinPostResource;
use App\Models\CategoryJoinPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryJoinPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/category-join-post",
     *      security={{"bearerAuth":{}}},
     *      operationId="CategoryJoinPost_index",
     *      tags={"CategoryJoinPost"},
     *      summary="All CategoryJoinPost",
     *      description="Hamma CategoryJoinPostlarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *       @OA\JsonContent(ref="#/components/schemas/CategoryJoinPost"),
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
        return CategoryJoinPostResource::collection(CategoryJoinPost::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/category-join-post",
     *      security={{"bearerAuth":{}}},
     *      operationId="CategoryJoinPost_store",
     *      tags={"CategoryJoinPost"},
     *      summary="new CategoryJoinPost add",
     *      description="Yangi CategoryJoinPost qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"category_id", "post_id"},
     *                  @OA\Property(property="category_id", type="number", format="integer", example="1"),
     *                  @OA\Property(property="post_id", type="number", format="integer", example="1"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryJoinPost"),
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
           'category_id' => 'required',
           'post_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new CategoryJoinPost();
            $model->category_id = $request->category_id;
            $model->post_id = $request->post_id;
            $model->save();
            return response()->json(new CategoryJoinPostResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/category-join-post/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show CategoryJoinPost",
     * description="bitta CategoryJoinPost hamma malumotlarini korsatadi",
     * operationId="CategoryJoinPost_show",
     * tags={"CategoryJoinPost"},
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
     *          @OA\JsonContent(ref="#/components/schemas/CategoryJoinPost"),
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
        $model = CategoryJoinPost::find($id);
        if($model){
            try {
                return new CategoryJoinPostResource($model);
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
     *      path="/api/v1/category-join-post/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="CategoryJoinPost_update",
     *      tags={"CategoryJoinPost"},
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
     *          @OA\JsonContent(required={"category_id", "post_id"},
     *               @OA\Property(property="category_id", type="number", example="1"),
     *               @OA\Property(property="post_id", type="number", example="1"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/CategoryJoinPost"),
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
            'category_id' => 'required',
            'post_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = CategoryJoinPost::find($id);
            if ($model){
                $model->update([
                    'category_id' => $request->category_id,
                    'post_id' => $request->post_id,
                ]);
                return response()->json(
                    new CategoryJoinPostResource($model), 
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/category-join-post/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="CategoryJoinPost_delete",
     *      tags={"CategoryJoinPost"},
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
     *         @OA\JsonContent(ref="#/components/schemas/CategoryJoinPost"),
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
        $model = CategoryJoinPost::find($id);
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
