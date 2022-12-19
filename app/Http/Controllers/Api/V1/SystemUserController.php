<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SystemUserResource;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/system-user",
     *      security={{"bearerAuth":{}}},
     *      operationId="SystemUser_index",
     *      tags={"SystemUser"},
     *      summary="All SystemUser",
     *      description="Hamma SystemUserlarni korish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/SystemUser"),
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
        return SystemUserResource::collection(SystemUser::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/system-user",
     *      security={{"bearerAuth":{}}},
     *      operationId="SystemUser_store",
     *      tags={"SystemUser"},
     *      summary="new SystemUser add",
     *      description="Yangi SystemUser qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","middlename","surname","email","password","language"},
     *                  @OA\Property(property="name", type="string", format="text", example="name"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="middlename"),
     *                  @OA\Property(property="surname", type="string", format="text", example="surname"),
     *                  @OA\Property(property="email", type="string", format="text", example="admin@gmail.com"),
     *                  @OA\Property(property="password", type="string", format="text", example="admin"),
     *                  @OA\Property(property="phone", type="string", format="text", example="+998901234567"),
     *                  @OA\Property(property="language", type="enum", format="text", example="uz"), 
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SystemUser"),
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
            'name' => 'required',
            'middlename' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'language' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new SystemUser();
            $model->name = $request->name;
            $model->middlename = $request->middlename;
            $model->surname = $request->surname;
            $model->email = $request->email;
            $model->password = $request->password;
            $model->phone = $request->phone;
            $model->language = $request->language;
            $model->save();
            return response()->json(new SystemUserResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/system-user/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show SystemUser",
     * description="bitta SystemUser hamma malumotlarini korsatadi",
     * operationId="SystemUser_show",
     * tags={"SystemUser"},
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
     *          @OA\JsonContent(ref="#/components/schemas/SystemUser"),
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
        $model = SystemUser::find($id);
        if($model){
            try {
                return new SystemUserResource($model);
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
     *      path="/api/v1/system-user/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="SystemUser_update",
     *      tags={"SystemUser"},
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
     *          @OA\JsonContent(required={"name","middlename","surname","email","password","language"},
     *               @OA\Property(property="file", type="string", format="binary"),
     *                  @OA\Property(property="name", type="string", format="text", example="name"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="middlename"),
     *                  @OA\Property(property="surname", type="string", format="text", example="surname"),
     *                  @OA\Property(property="email", type="string", format="text", example="admin@gmail.com"),
     *                  @OA\Property(property="password", type="string", format="text", example="admin"),
     *                  @OA\Property(property="phone", type="string", format="text", example="+998901234567"),
     *                  @OA\Property(property="language", type="enum", format="text", example="uz"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/SystemUser"),
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
            'name' => 'required',
            'middlename' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'language' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = SystemUser::find($id);
            if ($model){
                $model->update([
                    'name' => $request->name,
                    'middlename' => $request->middlename,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'password' => $request->password,
                    'phone' => $request->phone,
                    'language' => $request->language,
                ]);
                return response()->json(
                    new SystemUserResource($model), 
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/system-user/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="SystemUser_delete",
     *      tags={"SystemUser"},
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
     *         @OA\JsonContent(ref="#/components/schemas/SystemUser"),
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
        $model = SystemUser::find($id);
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