<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\WeightTargetController;

/*
|--------------------------------------------------------------------------
| 認証不要
|--------------------------------------------------------------------------
*/

// 新規会員登録（STEP1）
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// ログイン
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

/*
|--------------------------------------------------------------------------
| 認証後（ログイン必須）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ダッシュボード（体重管理トップ）
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ログアウト（Auth を使う）
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    /*
    |--------------------------------------------------------------------------
    | 体重ログ（Weight Log）
    |--------------------------------------------------------------------------
    */

    // 追加画面
    Route::get('/logs/create', [WeightLogController::class, 'create'])
        ->name('logs.create');

    // 追加保存
    Route::post('/logs', [WeightLogController::class, 'store'])
        ->name('logs.store');

    // 編集画面（えんぴつ）
    Route::get('/logs/{log}/edit', [WeightLogController::class, 'edit'])
        ->name('logs.edit');

    // 更新
    Route::put('/logs/{log}', [WeightLogController::class, 'update'])
        ->name('logs.update');

    // 削除
    Route::delete('/logs/{log}', [WeightLogController::class, 'destroy'])
        ->name('logs.destroy');

    /*
    |--------------------------------------------------------------------------
    | 目標体重
    |--------------------------------------------------------------------------
    */

    // 目標体重設定画面
    Route::get('/target/edit', [WeightTargetController::class, 'edit'])
        ->name('target.edit');

    // 目標体重更新
    Route::put('/target', [WeightTargetController::class, 'update'])
        ->name('target.update');
});

/*
|--------------------------------------------------------------------------
| トップアクセス時のリダイレクト
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});




