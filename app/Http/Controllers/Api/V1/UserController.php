<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['registerUser', 'putLenguage', 'putFio']]);
    }
    /**
     * @OA\Get(
     *      path="/api/v1/user",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_index",
     *      tags={"User"},
     *      summary="All User",
     *      description="Hamma Userlarni ko'rish",
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *        @OA\JsonContent(ref="#/components/schemas/User"),
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
        return UserResource::collection(User::all());
    }


    public function create()
    {
        //
    }
    
    /**
     * @OA\Post(
     *      path="/api/v1/user",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_store",
     *      tags={"User"},
     *      summary="new User add",
     *      description="Yangi User qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","middlename","surname", "phone", "language", "code"},
     *                  @OA\Property(property="name", type="string", format="text", example="name"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="middlename"),
     *                  @OA\Property(property="surname", type="string", format="text", example="surname"),
     *                  @OA\Property(property="phone", type="string", format="text", example="+998901234567"),
     *                  @OA\Property(property="language", type="enum", format="text", example="uz"),
     *                  @OA\Property(property="code", type="string", format="text", example="1254"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
            'phone' => 'required',
            'language' => 'required',
            'code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new User();
            $model->name = $request->name;
            $model->middlename = $request->middlename;
            $model->surname = $request->surname;
            $model->phone = $request->phone;
            $model->language = $request->language;
            $model->code = $request->code;
            $model->save();
            return response()->json(new UserResource($model),200);
        }
    }
    /**
     * @OA\Get(
     * path="/api/v1/user/{id}",
     * security={{"bearerAuth":{}}},
     * summary="Show User",
     * description="bitta User hamma malumotlarini korsatadi",
     * operationId="User_show",
     * tags={"User"},
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
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
        $model = User::find($id);
        if($model){
            try {
                return new UserResource($model);
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
     *      path="/api/v1/user/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_update",
     *      tags={"User"},
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
     *          @OA\JsonContent(required={"name","middlename","surname","phone","language", "code"},
     *                  @OA\Property(property="name", type="string", format="text", example="name"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="middlename"),
     *                  @OA\Property(property="surname", type="string", format="text", example="surname"),
     *                  @OA\Property(property="phone", type="string", format="text", example="+998901234567"),
     *                  @OA\Property(property="code", type="string", format="text", example="1254"),
     *                  @OA\Property(property="language", type="enum", format="text", example="uz"), 
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/User"),
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
            'phone' => 'required',
            'language' => 'required',
            'code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            
            $model = User::find($id);
            if ($model){
                $model->update([
                    'name' => $request->name,
                    'middlename' => $request->middlename,
                    'surname' => $request->surname,
                    'phone' => $request->phone,
                    'language' => $request->language,
                    'code' => $request->code,
                ]);
                return response()->json(
                    new UserResource($model),
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }
     /**
     * @OA\Delete(
     *      path="/api/v1/user/{id}",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_delete",
     *      tags={"User"},
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
     *         @OA\JsonContent(ref="#/components/schemas/User"),
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
        $model = User::find($id);
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
     *      path="/api/v1/register-user",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_register_user",
     *      tags={"User"},
     *      summary="new User add",
     *      description="User Registratsiya qoshish",
     *      @OA\RequestBody(
     *          required=true,
     *          description="save",
     *           @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","middlename","surname", "phone", "language", "code"},
     *                  @OA\Property(property="name", type="string", format="text", example="name"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="middlename"),
     *                  @OA\Property(property="surname", type="string", format="text", example="surname"),
     *                  @OA\Property(property="phone", type="string", format="text", example="+998901234567"),
     *                  @OA\Property(property="language", type="enum", format="text", example="uz"),
     *                  @OA\Property(property="code", type="string", format="text", example="1254"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
    public function registerUser(Request $request){
        $rules = [
            'name' => 'required',
            'middlename' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'language' => 'required',
            'code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = new User();
            $model->name = $request->name;
            $model->middlename = $request->middlename;
            $model->surname = $request->surname;
            $model->phone = $request->phone;
            $model->language = $request->language;
            $model->code = $request->code;
            $model->save();
            return response()->json(new UserResource($model),200);
        }
    }
    /**
     * @OA\Put(
     *      path="/api/v1/updete-lenguage/{lenguage}",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_lenguage_update",
     *      tags={"User"},
     *      summary="Update existing project",
     *      description="Returns updated project data",
     *      @OA\Parameter(
     *          name="lenguage",
     *          description="lenguage",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              enum={"lenguage_uz", "lenguage_ru","lenguage_eng"},
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/User"),
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
    public function putLenguage($language){
        $rules = [
            'language' => 'required',
        ];
        $validator = Validator::make($language, $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = auth()->user()->id;
            if ($model){
                $model->update([
                    'language' => $language,
                ]);
                return response()->json(
                    new UserResource($model),
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/updete-lenguage",
     *      security={{"bearerAuth":{}}},
     *      operationId="User_FIO_update",
     *      tags={"User"},
     *      summary="Update existing project",
     *      description="Returns updated project data",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Category",
     *          @OA\JsonContent(required={"name","middlename","surname"},
     *                  @OA\Property(property="name", type="string", format="text", example="name"),
     *                  @OA\Property(property="middlename", type="string", format="text", example="middlename"),
     *                  @OA\Property(property="surname", type="string", format="text", example="surname"),
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *              @OA\JsonContent(ref="#/components/schemas/User"),
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
    public function putFio(Request $request){
        $rules = [
            'name' => 'required',
            'middlename' => 'required',
            'surname' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $model = auth()->user()->id;
            if ($model){
                $model->update([
                    'name' => $request->name,
                    'middlename' => $request->middlename,
                    'surname' => $request->surname,
                ]);
                return response()->json(
                    new UserResource($model),
                    200);
            } else{
                return response()->json(['message' => 'Not found'], 404);
            }
        }
    }

}