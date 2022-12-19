<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionCategoryResource;
use App\Http\Resources\QuestionResource;
use App\Models\Post;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['postQuestion','getAllQuestion','getAllQuestionCategory']]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/question",
     *      security={{"bearerAuth":{}}},
     *      operationId="Question_index",
     *      tags={"Question"},
     *      summary="All Question",
     *      description="Hamma Questionlarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/Question"),
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
        return QuestionResource::collection(Question::all());
    }

    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/question",
     *      security={{"bearerAuth":{}}},
     *      operationId="Question_store",
     *      tags={"Question"},
     *      summary="new Question add",
     *      description="Yangi Question qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"title", "user_id",},
     *                  @OA\Property(property="title", type="string", format="text", example="Title"),
     *                  @OA\Property(property="user_id", type="number", format="integer", example="1"),
     *                  @OA\Property(property="content", type="string", format="text", example="content"),
     *                  @OA\Property(property="image", type="string", format="binary"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Question"),
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
            'title' => 'required',
            'user_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            if ($request->image) {
                $image = $request->file("image");
                $path = public_path("uploads/question_images/$request->title/");
                $image_name = $image->getClientOriginalName();
                $image->move($path, $image_name);

                $model = new Question();
                $model->title = $request->title;
                $model->user_id = $request->user_id;
                $model->content = $request->content;
                $model->image = asset("uploads/question_images/$request->title/$image_name");
                $model->save();
                return response()->json(new QuestionResource($model),200);
            }else{
                $model = new Question();
                $model->title = $request->title;
                $model->user_id = $request->user_id;
                $model->content = $request->content;
                $model->save();
                return response()->json(new QuestionResource($model),200);
            }
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/question/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show Question",
     * description="bitta Question hamma malumotlarini korsatadi",
     * operationId="Question_show",
     * tags={"Question"},
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
     *          @OA\JsonContent(ref="#/components/schemas/Question"),
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
        $model = Question::find($id);
        if($model){
            try {
                return new QuestionResource($model);
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
     *      path="/api/v1/question/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="Question_update",
     *      tags={"Question"},
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
     *        @OA\RequestBody(
     *          required=true,
     *          description="Category",
     *          @OA\JsonContent(required={"title","user_id"},
     *                  @OA\Property(property="title", type="string", format="text",example="Title"),
     *                  @OA\Property(property="user_id", type="number", format="integer",example="1"),
     *                  @OA\Property(property="content", type="string", format="text", example="content"),
     *                  @OA\Property(property="image",type="string",format="binary"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/Question"),
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
            'title' => 'required',
            'user_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            if ($request->image) {
                $image = $request->file("image");
                $path = public_path("uploads/question_images/$request->title/");
                $image_name = $image->getClientOriginalName();
                $image->move($path, $image_name);

                $model = Post::find($id);
                if ($model){
                    $model->update([
                        'title' => $request->title,
                        'user_id' => $request->user_id,
                        'content' => $request->content,
                        'image' => asset("uploads/question_images/$request->title/$image_name"),
                    ]);
                    return response()->json(
                        new QuestionResource($model), 
                        200);
                } else{
                    return response()->json(['message' => 'Not found'], 404);
                }
            }else{
                $model = Post::find($id);
                if ($model){
                    $model->update([
                        'title' => $request->title,
                        'user_id' => $request->user_id,
                        'content' => $request->content,
                    ]);
                    return response()->json(
                        new QuestionResource($model), 
                        200);
                } else{
                    return response()->json(['message' => 'Not found'], 404);
                }
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/question/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="Question_delete",
     *      tags={"Question"},
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
     *         @OA\JsonContent(ref="#/components/schemas/Question"),
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
        $model = Post::find($id);
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
    /**
     * @OA\Post(
     *      path="/api/v1/post-question-user",
     *      security={{"bearerAuth":{}}},
     *      operationId="Post_question_store",
     *      tags={"Question"},
     *      summary="new Question add",
     *      description="Yangi Question",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"title", "user_id"},
     *                  @OA\Property(property="title", type="string", format="text", example="Title"),
     *                  @OA\Property(property="user_id", type="number", format="integer", example="1"),
     *                  @OA\Property(property="content", type="string", format="text", example="content"),
     *                  @OA\Property(property="image", type="string", format="binary"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Question"),
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
    public function postQuestion(Request $request){
        $rules = [
            'title' => 'required',
            'user_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            if ($request->image) {
                $image = $request->file("image");
                $path = public_path("uploads/question_images/$request->title/");
                $image_name = $image->getClientOriginalName();
                $image->move($path, $image_name);

                $model = new Question();
                $model->title = $request->title;
                $model->user_id = $request->user_id;
                $model->content = $request->content;
                $model->image = asset("uploads/question_images/$request->title/$image_name");
                $model->save();
                return response()->json(new QuestionResource($model),200);
            }else{
                $model = new Question();
                $model->title = $request->title;
                $model->user_id = $request->user_id;
                $model->content = $request->content;
                $model->save();
                return response()->json(new QuestionResource($model),200);
            }
        }
    }
    /**
     * @OA\Get(
     *      path="/api/v1/get-all-question",
     *      security={{"bearerAuth":{}}},
     *      operationId="Question_get_all_question",
     *      tags={"Question"},
     *      summary="All Question",
     *      description="Hamma Questionlarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/Question"),
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
    public function getAllQuestion(){
        return QuestionResource::collection(Question::paginate(15));
    }
    /**
     * @OA\Get(
     *      path="/api/v1/get-all-question-category",
     *      security={{"bearerAuth":{}}},
     *      operationId="Question_get_all_question_category",
     *      tags={"Question"},
     *      summary="All Question Category",
     *      description="Hamma Question Categorylarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/Question"),
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
    public function getAllQuestionCategory(){
        return QuestionCategoryResource::collection(QuestionCategory::all());
    }

    /**
     * @OA\Get(
     * path="/api/v1/question-show/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show Question User",
     * description="bitta Question hamma malumotlarini korsatadi",
     * operationId="Question_show_user",
     * tags={"Question"},
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
     *          @OA\JsonContent(ref="#/components/schemas/Question"),
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
    public function getQuestionshow($id){
        $model = Question::find($id);
        if($model){
            try {
                return new QuestionResource($model);
                }catch (\Throwable $th) {
                    return response()->json([
                        "errors" =>["$th"],
                    ], 403);
                }
            }
            return response()->json(['errors' => ['Not found']], 404);
    }
}