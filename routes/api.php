<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{post}',[PostController::class,'show']);

Route::get('/posts/{post}/comments',
    [CommentController::class,'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout',
        [AuthController::class,'logout']);

    Route::post('/posts',
        [PostController::class,'store']);

    Route::put('/posts/{post}',
        [PostController::class,'update']);

    Route::delete('/posts/{post}',
        [PostController::class,'destroy']);

    Route::post('/posts/{post}/comments',
        [CommentController::class,'store']);

    Route::delete('/comments/{comment}',
        [CommentController::class,'destroy']);
});
