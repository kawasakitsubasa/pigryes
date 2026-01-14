<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeightTarget;

class WeightTargetController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // 既に登録があればそれ、なければnull
        $target = WeightTarget::where('user_id', $user->id)->first();

        return view('target.edit', [
            'target' => $target,
        ]);
    }

    public function update(\Illuminate\Http\Request $request)
    {
    $request->validate(
        [
            'target_weight' => [
                'required',
                // 数字（整数でも小数でもOK）
                'numeric',
                // 4桁まで（9999.9までOK）
                'max:9999.9',
                // 小数点は1桁まで（整数OK / 小数は1桁だけ）
                'regex:/^\d{1,4}(\.\d{1})?$/',
            ],
        ],
        [
            'target_weight.required' => '体重を入力してください',
            'target_weight.numeric'  => '数字で入力してください',
            'target_weight.max'      => '4桁までの数字で入力してください',
            'target_weight.regex'    => '小数点は1桁で入力してください',
        ]
    );

    $user = auth()->user();

    \App\Models\WeightTarget::updateOrCreate(
        ['user_id' => $user->id],
        ['target_weight' => $request->target_weight]
    );

    return redirect()->route('dashboard');
    }

}
