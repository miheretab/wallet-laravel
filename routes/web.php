<?php

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
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WalletsController;

//Route::get('/user', [UserController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('users.register');
})->name('register');
Route::get('/login', function () {
    return view('users.login');
})->name('login');

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);

Route::group(['middleware' => 'auth'], function () {

	Route::get('/home', function () {
		$user = Auth::user();
		return view('home')->with(['user' => $user]);
	})->name('home');
	Route::put('/use-token', [WalletsController::class, 'consume']);
	Route::put('/buy-token', [WalletsController::class, 'buy']);

});