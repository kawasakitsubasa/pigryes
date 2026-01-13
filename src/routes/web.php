<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ==============================
// 新規会員登録 STEP1
// ==============================
Route::get('/register', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'store']);

// ==============================
// 新規会員登録 STEP2（体重入力）
// ==============================
Route::get('/register/step2', function () {
    return view('auth.register_step2');
});
Route::post('/register/step2', [RegisterController::class, 'storeStep2']);

// ==============================
// 登録完了（仮）
// ==============================
Route::get('/register/complete', function () {
    return view('auth.register_complete'); // 無いなら作る or 文字でもOK
});

// ==============================
// ログイン
// ==============================
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


// ==============================
// 体重管理画面（ログイン必須）
// ==============================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ==============================
// ログアウト（簡易版）
// ※本番はPOST推奨。今は動かす優先でGETでも可
// ==============================
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

