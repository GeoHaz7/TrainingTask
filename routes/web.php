<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Store user to database
Route::post('/users', [UserController::class, 'store']);

//auth user 
Route::post('/auth', [UserController::class, 'auth']);

//Logout User
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Update Edited User
Route::put('/manage/users/{id}/update', [UserController::class, 'updateUser'])->middleware('auth');

//Delete User
Route::delete('/manage/users/{id}/delete', [UserController::class, 'deleteUser'])->middleware('auth');

//Delete Post
Route::delete('/manage/posts/{id}/delete', [PostController::class, 'deletePost'])->middleware('auth');

//Delete comment
Route::delete('/manage/comments/{id}/delete', [CommentController::class, 'deleteComment'])->middleware('auth');

//Update Edited Post
Route::put('/posts/{id}/put', [PostController::class, 'updatePost'])->middleware('auth');

//Store new post
Route::post('/posts/add', [PostController::class, 'storePost']);

//Store new comment
Route::post('/posts/{id}/comment', [CommentController::class, 'storeComment']);

//toggle comment status
Route::put('/manage/comments/{id}/toggle', [CommentController::class, 'toggleComment'])->middleware('auth');

//like post
Route::get('/posts/{id}/like', [LikesController::class, 'likePost']);

//get Likes post
Route::get('/likes', [LikesController::class, 'getLikes']);

//dislike post
Route::get('/posts/{id}/dislike', [LikesController::class, 'dislikePost']);

//get Likes post
Route::get('/dislikes', [LikesController::class, 'getDislikes']);


// //All blogs
// Route::get('/', [PostController::class, 'index']);

// //Show Login View
// Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');

// //Show Register View
// Route::get('/register', [UserController::class, 'register'])->middleware('guest');

// //Manage Users
// Route::get('/manage/users', [UserController::class, 'manage'])->middleware('auth');

// //Edit User view
// Route::get('/manage/users/{id}/edit', [UserController::class, 'editUser'])->middleware('auth');

// //Show Posts for a user
// Route::get('/posts/user/{user_id}', [PostController::class, 'userPosts'])->middleware('auth');

// //Show Edit post view
// Route::get('/posts/{id}/edit', [PostController::class, 'editPost'])->middleware('auth');

// //Show add post view
// Route::get('/posts/add', [PostController::class, 'addPost'])->middleware('auth');

// //Admin add user
// Route::get('/manage/users/add', [UserController::class, 'register'])->middleware('auth');
