<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/register/step2', function () {return view('auth.register_step2');});
Route::post('/register/step2', [RegisterController::class, 'storeStep2']);
Route::get('/register/complete', function () {return '登録完了（仮）';});
Route::get('/login', function () {return view('auth.login');});

