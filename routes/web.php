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

//Show All Posts
Route::get('/', [PostController::class, 'index']);


//Show Login View
Route::get('/login', [UserController::class, 'login']);

//Show Register View
Route::get('/register', [UserController::class, 'register']);

//Store user to database
Route::post('/users', [UserController::class, 'store']);

//auth user 
Route::post('/auth', [UserController::class, 'auth']);
