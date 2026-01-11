<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function show()
    {
       return view('auth.register');
    }

    public function store(Request $request)
    {
       $request->validate(
        [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ],
        [
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ]
       );

       return redirect('/register/step2');
    }

    public function storeStep2(Request $request)
    {
       $request->validate(
        [
            'current_weight' => 'required|numeric',
            'target_weight'  => 'required|numeric',
        ],
        [
            'current_weight.required' => '現在の体重を入力してください',
            'target_weight.required'  => '目標の体重を入力してください',
        ]
       );

       return redirect('/register/complete');
    }


}
