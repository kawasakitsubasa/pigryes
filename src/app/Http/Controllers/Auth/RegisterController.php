<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WeightTarget;
use App\Models\WeightLog;
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
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
       ],
       [
        'name.required' => '名前を入力してください',
        'email.required' => 'メールアドレスを入力してください',
        'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
        'email.unique' => 'このメールアドレスは既に登録されています',
        'password.required' => 'パスワードを入力してください',
       ]
      );


        // STEP1の入力を一時保存
        $request->session()->put('register.step1', $validated);

        return redirect()->route('register.step2');
    }

    /**
     * STEP2 画面表示
     */
    public function step2(Request $request)
    {
        // STEP1が無いなら戻す
        if (!$request->session()->has('register.step1')) {
            return redirect()->route('register');
        }

        return view('auth.register_step2');
    }

    /**
     * STEP2 入力チェック → ユーザー作成（＋目標体重＆初回ログも作る）
     */
    public function storeStep2(Request $request)
    {
        $step1 = $request->session()->get('register.step1');
        if (!$step1) {
            return redirect()->route('register');
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

            // ① user 作成
            $user = User::create([
                'name' => $step1['name'],
                'email' => $step1['email'],
                'password' => Hash::make($step1['password']),
                // usersテーブルに current_weight/target_weight があるなら残してOK
                'current_weight' => $validated2['current_weight'],
                'target_weight'  => $validated2['target_weight'],
            ]);

            // ② weight_targets にも保存（dashboardがこれを見る）
            WeightTarget::updateOrCreate(
                ['user_id' => $user->id],
                ['target_weight' => $validated2['target_weight']]
            );

            // ③ weight_logs に「初回の現在体重」を1件作る（最新体重表示に必要）
            WeightLog::create([
                'user_id' => $user->id,
                'date' => now()->toDateString(),
                'weight' => $validated2['current_weight'],
                'calories' => 0,
                'exercise_minutes' => 0,
                // 'exercise_content' => null, // 
            ]);

            // セッション破棄
            $request->session()->forget('register.step1');
        });

        return redirect()->route('register.complete');
    }

    /**
     * 登録完了画面
     */
    public function complete()
    {
        return redirect()->route('register.complete');

    }
}
