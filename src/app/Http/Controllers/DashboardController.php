<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeightTarget;
use App\Models\WeightLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 目標体重
        $target = WeightTarget::where('user_id', $user->id)->first();
        $targetWeight = $target?->target_weight;

        // 日付検索のバリデーション（古い〜新しい）
        $request->validate(
            [
                'from' => ['nullable', 'date'],
                'to'   => ['nullable', 'date', 'after_or_equal:from'],
            ],
            [
                'from.date' => '開始日は正しい日付で入力してください',
                'to.date' => '終了日は正しい日付で入力してください',
                'to.after_or_equal' => '終了日は開始日以降の日付を選んでください',
            ]
        );

        // 一覧クエリ（ログインユーザーのデータのみ）
        $logsQuery = WeightLog::where('user_id', $user->id)
            ->orderByDesc('date');

        // 検索条件（from/to）
        if ($request->filled('from')) {
            $logsQuery->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $logsQuery->whereDate('date', '<=', $request->to);
        }

        // 件数（検索結果表示用）
        $totalCount = (clone $logsQuery)->count();

        // 8件ごとページネーション
        $logs = $logsQuery->paginate(8);

        // ✅ 検索している時だけクエリを保持（更新で消える問題の対策）
        if ($request->filled('from') || $request->filled('to')) {
            $logs->appends($request->query());
        }

        // 最新体重（表示中の一覧の先頭＝最新）
        $latestWeight = optional($logs->first())->weight;

        // 目標まで（目標 - 現在）
        $diffToTarget = null;
        if ($latestWeight !== null && $targetWeight !== null) {
            $diffToTarget = $targetWeight - $latestWeight;
        }

        return view('dashboard.index', [
            'logs' => $logs,
            'targetWeight' => $targetWeight,
            'latestWeight' => $latestWeight,
            'diffToTarget' => $diffToTarget,
            'totalCount' => $totalCount,
        ]);
    }
}

