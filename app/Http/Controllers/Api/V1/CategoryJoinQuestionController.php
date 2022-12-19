<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoryJoinQuestion;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryJoinQuestionResource;
use Illuminate\Support\Facades\Validator;

class CategoryJoinQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/category-join-question",
     *      security={{"bearerAuth":{}}},
     *      operationId="Category_Join_Question_index",
     *      tags={"CategoryJoinQuestion"},
     *      summary="All CategoryJoinQuestion",
     *      description="Hamma CategoryJoinQuestionlarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *       @OA\JsonContent(ref="#/components/schemas/CategoryJoinQuestion"),
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
        return CategoryJoinQuestionResource::collection(CategoryJoinQuestion::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/category-join-question",
     *      security={{"bearerAuth":{}}},
     *      operationId="Category_Join_Question_store",
     *      tags={"CategoryJoinQuestion"},
     *      summary="new CategoryJoinQuestion add",
     *      description="Yangi CategoryJoinQuestion qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"category_id", "question_id"},
     *                  @OA\Property(property="category_id", type="number", format="integer", example="1"),
     *                  @OA\Property(property="question_id", type="number", format="integer", example="1"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryJoinQuestion"),
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
           'question_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new CategoryJoinQuestion();
            $model->category_id = $request->category_id;
            $model->question_id = $request->question_id;
            $model->save();
            return response()->json(new CategoryJoinQuestionResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/category-join-question/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show Category Join Question",
     * description="bitta CategoryJoinQuestion hamma malumotlarini korsatadi",
     * operationId="Category_Join_Question_show",
     * tags={"CategoryJoinQuestion"},
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
     *          @OA\JsonContent(ref="#/components/schemas/CategoryJoinQuestion"),
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
        $model = CategoryJoinQuestion::find($id);
        if($model){
            try {
                return new CategoryJoinQuestionResource($model);
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
     *      path="/api/v1/category-join-question/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="CategoryJoinQuestion_update",
     *      tags={"CategoryJoinQuestion"},
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
     *          @OA\JsonContent(required={"category_id", "question_id"},
     *               @OA\Property(property="category_id", type="number", example="1"),
     *               @OA\Property(property="question_id", type="number", example="1"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/CategoryJoinQuestion"),
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
            'question_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = CategoryJoinQuestion::find($id);
            if ($model){
                $model->update([
                    'category_id' => $request->category_id,
                    'question_id' => $request->question_id,
                ]);
                return response()->json(
                    new CategoryJoinQuestionResource($model), 
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/category-join-question/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="Category_Join_Question_delete",
     *      tags={"CategoryJoinQuestion"},
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
     *         @OA\JsonContent(ref="#/components/schemas/CategoryJoinQuestion"),
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
        $model = CategoryJoinQuestion::find($id);
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
