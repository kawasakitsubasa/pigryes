<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * ログイン画面表示
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     */
    public function login(Request $request)
    {
        // ① 入力チェック（未入力・形式）
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
                'password.required' => 'パスワードを入力してください',
            ]
        );

        // ② DBと照合（一致しなければログイン不可）
        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'login' => 'メールアドレスまたはパスワードが正しくありません',
                ])
                ->withInput();
        }

        // ③ セッション固定攻撃対策（ログイン後にセッションID再生成）
        $request->session()->regenerate();

        // ④ 成功したら体重管理画面へ
        return redirect()->route('dashboard');
    }
}


