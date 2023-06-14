<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::get('/posts', [PostController::class, 'getPosts']);
    Route::get('/posts/{id}', [PostController::class, 'getPost']);

    Route::get('/comments', [CommentController::class, 'getComments']);
    Route::get('/comments/{id}', [CommentController::class, 'getComment']);
    Route::get('/posts/{post_id}/comments', [PostController::class, 'getPostComments']);
    Route::get('/users/{user_id}/comments', [UserController::class, 'getUserComments']);
    Route::post('/comments', [CommentController::class, 'createComment']);
    Route::patch('/comments/{id}', [CommentController::class, 'updateComment']);
    Route::delete('/comments/{id}', [CommentController::class, 'deleteComment']);

    Route::get('/categories', [CategoryController::class, 'getAllCategories']);
    Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);

    Route::get('/tags', [TagController::class, 'getAllTags']);
    Route::get('/tags/{id}', [TagController::class, 'getTag']);



    Route::middleware(['is_admin'])->group(function () {

        Route::post('/users', [UserController::class, 'create']);
        Route::patch('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'delete']);

        Route::post('/posts', [PostController::class, 'createPost']);
        Route::patch('/posts/{id}', [PostController::class, 'updatePost']);
        Route::delete('/posts/{id}', [PostController::class, 'deletePost']);

        Route::post('/categories', [CategoryController::class, 'createCategory']);
        Route::patch('/categories/{id}', [CategoryController::class, 'updateCategory']);
        Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

        Route::post('/tags', [TagController::class, 'createTag']);
        Route::patch('/tags/{id}', [TagController::class, 'updateTag']);
        Route::delete('/tags/{id}', [TagController::class, 'deleteTag']);

        Route::get('/approve-comment/{id}', [AdminController::class, 'approveComment']);
        Route::get('/approve-post/{id}', [AdminController::class, 'approvePost']);
    });

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



