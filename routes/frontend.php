<?php

use App\Http\Controllers\CommentController;
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

//All blogs
Route::get('/', [PostController::class, 'index']);

//Show Login View
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');

//Show Register View
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

//Manage Users
Route::get('/manage/users', [UserController::class, 'manageUsers'])->middleware('auth');

//Edit User view
Route::get('/manage/users/{id}/edit', [UserController::class, 'editUser'])->middleware('auth');

//Show Posts for a user
Route::get('/posts/user/{user_id}', [PostController::class, 'userPosts'])->middleware('auth');

//Manage Comments
Route::get('/manage/comments', [CommentController::class, 'manageComments'])->middleware('auth');


//Show add post view
Route::get('/posts/add', [PostController::class, 'addPost'])->middleware('auth');

//Admin add user
Route::get('/manage/users/add', [UserController::class, 'register'])->middleware('auth');

//Show single Post
Route::get('/posts/{id}/show', [PostController::class, 'showPost']);

//Show Edit post view
Route::get('/posts/{id}/edit', [PostController::class, 'editPost'])->middleware('auth');
