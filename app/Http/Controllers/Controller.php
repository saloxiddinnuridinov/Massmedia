<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *    title="Preloadet",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 * @OA\Tag(
 * name = "Auth",
 * description = "Auth System User",
 * ),
 * @OA\Tag(
 * name = "SystemUser",
 * description = "System User",
 * ),
 * @OA\Tag(
 * name = "User",
 * description = "User",
 * ),
 * @OA\Tag(
 * name = "PostCategory",
 * description = "Category Post",
 * ),
 * @OA\Tag(
 * name = "QuestionCategory",
 * description = "Question Category",
 * ),
 * @OA\Tag(
 * name = "File",
 * description = "File",
 * ),
 * @OA\Tag(
 * name = "Post",
 * description = "Post",
 * ),
 * @OA\Tag(
 * name = "Question",
 * description = "Question",
 * ),
 * @OA\Tag(
 * name = "PostJoinFile",
 * description = "Post Join File",
 * ),
 * @OA\Tag(
 * name = "QuestionJoinFile",
 * description = "Question Join File",
 * ),
 * @OA\Tag(
 * name = "CategoryJoinQuestion",
 * description = "Category Join Question",
 * ),
 * @OA\Tag(
 * name = "CategoryJoinPost",
 * description = "Category Join Post",
 * ),
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
