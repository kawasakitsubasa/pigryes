<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * STEP1 登録画面表示
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * STEP1 入力チェック → OKならSTEP2へ
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
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

        // STEP1の入力を一時保存（メモ）
        $request->session()->put('register.step1', $validated);

        return redirect('/register/step2');
    }

    /**
     * STEP2 入力チェック → ユーザー作成
     */
    public function storeStep2(Request $request)
    {
    
        $step1 = $request->session()->get('register.step1');
        if (!$step1) {
            return redirect('/register');
        }

        $validated2 = $request->validate(
            [
                'current_weight' => [
                    'required',
                    'numeric',
                    'max:9999.9',
                    'regex:/^\d{1,4}(\.\d{1})?$/',
                ],
                'target_weight' => [
                    'required',
                    'numeric',
                    'max:9999.9',
                    'regex:/^\d{1,4}(\.\d{1})?$/',
                ],
            ],
            [
                'current_weight.required' => '体重を入力してください',
                'current_weight.numeric'  => '数字で入力してください',
                'current_weight.max'      => '4桁までの数字で入力してください',
                'current_weight.regex'    => '小数点は1桁で入力してください',

                'target_weight.required' => '体重を入力してください',
                'target_weight.numeric'  => '数字で入力してください',
                'target_weight.max'      => '4桁までの数字で入力してください',
                'target_weight.regex'    => '小数点は1桁で入力してください',
            ]
        );

        
        DB::transaction(function () use ($step1, $validated2, $request) {
            User::create([
                'name' => $step1['name'],
                'email' => $step1['email'],
                'password' => Hash::make($step1['password']),
                'current_weight' => $validated2['current_weight'],
                'target_weight'  => $validated2['target_weight'],
            ]);

            
            $request->session()->forget('register.step1');
        });

        return redirect('/register/complete');
    }
}
