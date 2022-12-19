<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionCategoryResource;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/question-category",
     *      security={{"bearerAuth":{}}},
     *      operationId="question_category_index",
     *      tags={"QuestionCategory"},
     *      summary="All question Category",
     *      description="Hamma question Categorylarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/QuestionCategory"),
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
        return QuestionCategoryResource::collection(QuestionCategory::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/question-category",
     *      security={{"bearerAuth":{}}},
     *      operationId="question_Category_store",
     *      tags={"QuestionCategory"},
     *      summary="new question Category add",
     *      description="Yangi question Category qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name_uz", "name_ru", "name_eng"},
     *                  @OA\Property(property="name_uz", type="string", format="text",example="Uzbek"),
     *                  @OA\Property(property="name_ru", type="string", format="text", example="Russian"),
     *                  @OA\Property(property="name_eng", type="string", format="text", example="English"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/QuestionCategory"),
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
            'name_uz' => 'required',
            'name_ru' => 'required',
            'name_eng' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new QuestionCategory();
            $model->name_uz = $request->name_uz;
            $model->name_ru = $request->name_ru;
            $model->name_eng = $request->name_eng;
            $model->save();
            return response()->json(new QuestionCategoryResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/question-category/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show category",
     * description="bitta question Category hamma malumotlarini korsatadi",
     * operationId="question_Cateogry_show",
     * tags={"QuestionCategory"},
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
     *          @OA\JsonContent(ref="#/components/schemas/QuestionCategory"),
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
        $model = QuestionCategory::find($id);
        if($model){
            try {
                return new QuestionCategoryResource($model);
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
     *      path="/api/v1/question-category/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="question_Category_update",
     *      tags={"QuestionCategory"},
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
     *          description="QuestionCategory",
     *          @OA\JsonContent(required={"name_uz", "name_ru", "name_eng"},
     *               @OA\Property(property="name_uz", type="string", example="Harley"),
     *               @OA\Property(property="name_ru", type="string", example="Harley"),
     *               @OA\Property(property="name_eng", type="string", example="Harley"),
    *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/QuestionCategory"),
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
            'name_uz' => 'required',
            'name_ru' => 'required',
            'name_eng' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            
            $model = QuestionCategory::find($id);
            if ($model){
                $model->update([
                    'name_uz' => $request->name_uz,
                    'name_ru' => $request->name_ru,
                    'name_eng' => $request->name_eng,
                ]);
                return response()->json(
                    new QuestionCategoryResource($model), 
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/question-category/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="question_Category_delete",
     *      tags={"QuestionCategory"},
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
     *         @OA\JsonContent(ref="#/components/schemas/QuestionCategory"),
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
        $model = QuestionCategory::find($id);
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
