<?php

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

// Auth::route();
//Show All Posts
Route::get('/', [PostController::class, 'index'])->middleware('auth');


//Show Login View
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');

//Show Register View
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

//Store user to database
Route::post('/users', [UserController::class, 'store']);

//auth user 
Route::post('/auth', [UserController::class, 'auth']);

//Logout User
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Manage Users
Route::get('/manage/users', [UserController::class, 'manage'])->middleware('auth');

//Edit User view
Route::get('/manage/users/{id}/edit', [UserController::class, 'editUser'])->middleware('auth');

//Update Edited User
Route::put('/manage/users/{id}/update', [UserController::class, 'updateUser'])->middleware('auth');

//Delete User
Route::delete('/manage/users/{id}/delete', [UserController::class, 'deleteUser'])->middleware('auth');

//Delete Post
Route::delete('/manage/posts/{id}/delete', [PostController::class, 'deletePost'])->middleware('auth');

//Show Posts for a user
Route::get('/posts/user/{user_id}', [PostController::class, 'userPosts'])->middleware('auth');

//Show Edit post view
Route::get('/posts/{id}/edit', [PostController::class, 'editPost'])->middleware('auth');

//Show Edit post view
Route::get('/posts/add', [PostController::class, 'addPost'])->middleware('auth');

//Update Edited Post
Route::put('/posts/{id}/put', [PostController::class, 'updatePost'])->middleware('auth');

//Admin add user
Route::get('/manage/users/add', [UserController::class, 'register'])->middleware('auth');

//Store new post
Route::post('/posts/add', [PostController::class, 'storePost']);
