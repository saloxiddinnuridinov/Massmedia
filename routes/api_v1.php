<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//System User 
Route::post('login',[\App\Http\Controllers\API\V1\AuthController::class,'login']);
Route::post('register',[\App\Http\Controllers\API\V1\AuthController::class,'register']);

//User Register
Route::post('register-user',[\App\Http\Controllers\API\V1\UserController::class,'registerUser']);
//settings
Route::put('update-language/{language}',[\App\Http\Controllers\API\V1\UserController::class,'putLenguage']);
//update FIO
Route::put('update-language',[\App\Http\Controllers\API\V1\UserController::class,'putFio']);


//User Question 
Route::post('post-question-user',[\App\Http\Controllers\API\V1\QuestionController::class,'postQuestion']);
Route::get('get-all-question',[\App\Http\Controllers\API\V1\QuestionController::class,'getAllQuestion']);
//Question #Category question id show
Route::get('get-all-question-category',[\App\Http\Controllers\API\V1\QuestionController::class,'getAllQuestionCategory']);
Route::get('question-show/{id}',[\App\Http\Controllers\API\V1\QuestionController::class,'getQuestionshow']);

//User Post
Route::get('all-post',[\App\Http\Controllers\API\V1\PostController::class,'getAllPost']);
Route::get('post-join-category/{id}',[\App\Http\Controllers\API\V1\PostController::class,'getPostJoinCategory']);
//Post Category post id show
Route::get('all-category-post',[\App\Http\Controllers\API\V1\PostController::class,'getAllCategoryPost']);
//show post
Route::get('post-show/{id}',[\App\Http\Controllers\API\V1\PostController::class,'getPostshow']);

Route::resource('user', UserController::class);
Route::resource('system-user', SystemUserController::class);
Route::resource('post-category', PostCategoryController::class);
Route::resource('question-category', QuestionCategoryController::class);
Route::resource('file', FileController::class);
Route::resource('post', PostController::class);
Route::resource('question', QuestionController::class);
Route::resource('post-join-file', PostJoinFileController::class);
Route::resource('question-join-file', QuestionJoinFileController::class);
Route::resource('category-join-post', CategoryJoinPostController::class);
Route::resource('category-join-question', CategoryJoinQuestionController::class);