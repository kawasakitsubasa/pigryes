<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    public function create()
    {
        return view('logs.create');
    }

    public function store(Request $request)
    {
        // ✅ スクショ通りのエラーメッセージに合わせたバリデーション
        $validated = $request->validate(
            [
                // 1. 日付
                'date' => ['required', 'date'],

                // 2. 体重
                // まず「未入力」「数字じゃない」をLaravel標準で判定
                'weight' => ['required', 'numeric'],

                // 3. 摂取カロリー
                'calories' => ['required', 'integer'],

                // 4. 運動時間（00:00）
                'exercise_time' => ['required', 'date_format:H:i'],

                // 5. 運動内容（120文字以内）
                'exercise_content' => ['nullable', 'string', 'max:120'],
            ],
            [
                // 1. 日付
                'date.required' => '日付を入力してください',

                // 2. 体重
                'weight.required' => '体重を入力してください',
                'weight.numeric'  => '数字で入力してください',

                // 3. 摂取カロリー
                'calories.required' => '摂取カロリーを入力してください',
                'calories.integer'  => '数字で入力してください',

                // 4. 運動時間
                'exercise_time.required'    => '運動時間を入力してください',
                // 形式違いでも同じ文言に寄せる（スクショ寄せ）
                'exercise_time.date_format' => '運動時間を入力してください',

                // 5. 運動内容
                'exercise_content.max' => '120文字以内で入力してください',
            ]
        );

        // ✅ 体重の追加チェック（4桁まで／小数点は1桁）
        // ここでメッセージを分けてスクショ完全一致にする
        $w = (string) $request->input('weight', '');

        // 全角ドット対策（46．5 みたいなのを . に寄せる）
        $w = str_replace('．', '.', $w);

        if ($request->filled('weight')) {
            $parts = explode('.', $w);
            $intPart = $parts[0] ?? '';
            $decPart = $parts[1] ?? '';

            // 4桁まで（整数部）
            if (strlen($intPart) > 4) {
                return back()
                    ->withErrors(['weight' => '4桁までの数字で入力してください'])
                    ->withInput();
            }

            // 小数点は1桁（小数がある場合のみ）
            if ($decPart !== '' && strlen($decPart) !== 1) {
                return back()
                    ->withErrors(['weight' => '小数点は1桁で入力してください'])
                    ->withInput();
            }
        }

        // ✅ 運動時間 HH:MM → 分へ変換（DBは exercise_minutes）
        [$h, $m] = array_map('intval', explode(':', $validated['exercise_time']));
        $minutes = $h * 60 + $m;

        // ✅ 保存
        $data = [
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'weight' => $w, // 全角ドット対策後の値で保存
            'calories' => $validated['calories'],
            'exercise_minutes' => $minutes,
        ];

        // exercise_content をDBに保存する列がある場合だけ追加してね
        // （列を追加してないなら、このままでOK）
        if ($request->has('exercise_content')) {
            $data['exercise_content'] = $validated['exercise_content'] ?? null;
        }

        WeightLog::create($data);

        return redirect()->route('dashboard');
    }
    public function edit(WeightLog $log)
    {
    // ✅ 他人のデータを編集できないようにする
      abort_unless($log->user_id === Auth::id(), 403);

    // exercise_minutes を time(H:i) 表示に変換
       $hours = intdiv($log->exercise_minutes, 60);
       $minutes = $log->exercise_minutes % 60;
       $exercise_time = sprintf('%02d:%02d', $hours, $minutes);

       return view('logs.edit', compact('log', 'exercise_time'));
    }

    public function update(Request $request, WeightLog $log)
    {
       abort_unless($log->user_id === Auth::id(), 403);

    // ✅ バリデーション（追加画面と同じルール）
       $validated = $request->validate(
        [
            'date' => ['required', 'date'],
            'weight' => ['required', 'numeric'],
            'calories' => ['required', 'integer'],
            'exercise_time' => ['required', 'date_format:H:i'],
            'exercise_content' => ['nullable', 'string', 'max:120'],
        ],
        [
            'date.required' => '日付を入力してください',

            'weight.required' => '体重を入力してください',
            'weight.numeric'  => '数字で入力してください',

            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer'  => '数字で入力してください',

            'exercise_time.required'    => '運動時間を入力してください',
            'exercise_time.date_format' => '運動時間を入力してください',

            'exercise_content.max' => '120文字以内で入力してください',
        ]
    );

    // ✅ 体重の追加チェック（4桁／小数1桁）
        $w = (string) $request->input('weight', '');
        $w = str_replace('．', '.', $w);

        $parts = explode('.', $w);
        $intPart = $parts[0] ?? '';
        $decPart = $parts[1] ?? '';

        if (strlen($intPart) > 4) {
           return back()->withErrors(['weight' => '4桁までの数字で入力してください'])->withInput();
        }
        if ($decPart !== '' && strlen($decPart) !== 1) {
           return back()->withErrors(['weight' => '小数点は1桁で入力してください'])->withInput();
        }

    // HH:MM → 分
        [$h, $m] = array_map('intval', explode(':', $validated['exercise_time']));
        $minutes = $h * 60 + $m;

        $log->update([
         'date' => $validated['date'],
         'weight' => $w,
         'calories' => $validated['calories'],
         'exercise_minutes' => $minutes,
         'exercise_content' => $validated['exercise_content'] ?? null,
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy(WeightLog $log)
    {
       abort_unless($log->user_id === Auth::id(), 403);

       $log->delete();

       return redirect()->route('dashboard')->with('success', '更新しました');
    }

}


