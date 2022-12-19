<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostUserResource;
use App\Models\PostCategory;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAllPost', 'getPostJoinCategory', 'getAllCategoryPost', 'getPostshow']]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post",
     *      security={{"bearerAuth":{}}},
     *      operationId="Post_index",
     *      tags={"Post"},
     *      summary="All Post",
     *      description="Hamma Postlarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/Post"),
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
        return PostResource::collection(Post::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/post",
     *      security={{"bearerAuth":{}}},
     *      operationId="Post_store",
     *      tags={"Post"},
     *      summary="new Post add",
     *      description="Yangi Post qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"title", "content", "image"},
     *                  @OA\Property(property="title", type="string", format="text",example="Title"),
     *                  @OA\Property(property="content", type="string", format="text", example="content"),
     *                  @OA\Property(property="image",type="string",format="binary"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Post"),
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
            'content' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $image = $request->file("image");
            $path = public_path("uploads/post_images/$request->title/");
            $image_name = $image->getClientOriginalName();
            $image->move($path, $image_name);
            
            $model = new Post();
            $model->title = $request->title;
            $model->content = $request->content;
            $model->image = asset("uploads/post_images/$request->title/$image_name");
            $model->save();
            return response()->json(new PostResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/post/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show Post",
     * description="bitta Post hamma malumotlarini korsatadi",
     * operationId="Post_show",
     * tags={"Post"},
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
     *          @OA\JsonContent(ref="#/components/schemas/Post"),
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
        $model = Post::find($id);
        if($model){
            try {
                return new PostResource($model);
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
     *      path="/api/v1/post/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="Post_update",
     *      tags={"Post"},
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
     *          @OA\JsonContent(required={"title", "content"},
     *               @OA\Property(property="file", type="string", format="binary"),
     *                  @OA\Property(property="title", type="string", format="text",example="Title"),
     *                  @OA\Property(property="content", type="string", format="text", example="content"),
     *                  @OA\Property(property="image",type="string",format="binary"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/Post"),
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
            'content' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            if ($request->image) {
                $image = $request->file("image");
                $path = public_path("uploads/post_images/$request->title/");
                $image_name = $image->getClientOriginalName();
                $image->move($path, $image_name);

                $model = Post::find($id);
                if ($model){
                    $model->update([
                        'title' => $request->title,
                        'content' => $request->content,
                        'image' => asset("uploads/post_images/$request->title/$image_name"),
                    ]);
                    return response()->json(
                        new PostResource($model), 
                        200);
                } else{
                    return response()->json(['message' => 'Not found'], 404);
                }
            }else{
                $model = Post::find($id);
                if ($model){
                    $model->update([
                        'title' => $request->title,
                        'content' => $request->content,
                    ]);
                    return response()->json(
                        new PostResource($model), 
                        200);
                } else{
                    return response()->json(['message' => 'Not found'], 404);
                }
            }
            
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/post/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="Post_delete",
     *      tags={"Post"},
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
     *         @OA\JsonContent(ref="#/components/schemas/Post"),
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
     * @OA\Get( 
     *      path="/api/v1/all-post",
     *      operationId="Get_all_post_paginate",
     *      tags={"Post"},
     *      summary="All Post Paginate",
     *      security={{"bearerAuth":{}}},
     *      description="Hamma Postlarni ko'rish Pagination orqali",
     *      @OA\Response(response=200,
     *          description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Post"),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getAllPost()
    {
        return PostResource::collection(Post::paginate(15));
    }
    
    /**
     * @OA\Get(
     * path="/api/v1/post-join-category/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Get Post join Category",
     * description="Category Join post",
     * operationId="Category_Join_Post",
     * tags={"Post"},
     * @OA\Parameter(
     *    name="id",
     *    description="id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="number"
     *    )
     * ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post"),
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
    public function getPostJoinCategory($id)
    {
        $post = Post::select("*")
        ->join("category_join_posts", "posts.id", "=", "category_join_posts.post_id")
        ->where("category_join_posts.category_id", "$id");
        return $post;
        return PostUserResource::collection($post);
        //join('posts', 'users.id', '=', 'posts.user_id');
    }

    /**
     * @OA\Get( 
     *      path="/api/v1/all-category-post",
     *      operationId="Get_all_category_post",
     *      tags={"Post"},
     *      summary="All Category Post Paginate",
     *      security={{"bearerAuth":{}}},
     *      description="Hamma category postlarni ko'rish Pagination orqali",
     *      @OA\Response(response=200,
     *          description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/PostCategory"),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getAllCategoryPost(){
        return PostCategoryResource::collection(PostCategory::all());
    }
    /**
     * @OA\Get(
     * path="/api/v1/post-show/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show Post User",
     * description="bitta Post hamma malumotlarini korsatadi",
     * operationId="Post_user_show",
     * tags={"Post"},
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
     *          @OA\JsonContent(ref="#/components/schemas/Post"),
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
    public function getPostshow($id){
        $model = Post::find($id);
        if($model){
            try {
                return new PostResource($model);
                }catch (\Throwable $th) {
                    return response()->json([
                        "errors" =>["$th"],
                    ], 403);
                }
            }
            return response()->json(['errors' => ['Not found']], 404);
    }
}