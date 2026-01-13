<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>PiGLy 体重管理</title>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f7f7f7;
        }

        h1 {
            margin-bottom: 16px;
        }

        .container {
            max-width: 900px;
            margin: 24px auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
        }

        /* ===== 検索フォーム ===== */
        .search-area {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .search-area input[type="date"] {
            padding: 6px;
        }

        .search-area button,
        .search-area a {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .search-btn {
            background: #888;
            color: #fff;
        }

        .reset-btn {
            background: #ddd;
            color: #333;
        }

        .result-text {
            margin-bottom: 16px;
            color: #555;
        }

        /* ===== サマリー ===== */
        .summary {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-box {
            flex: 1;
            background: #fafafa;
            padding: 16px;
            border-radius: 10px;
            text-align: center;
        }

        .summary-box p {
            margin: 4px 0;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
        }

        /* ===== テーブル ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            border-bottom: 2px solid #ddd;
            padding: 8px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #faf6ff; /* hover */
        }

        /* えんぴつ */
        .edit-btn {
            text-decoration: none;
            font-size: 18px;
        }

        .edit-btn:hover {
            opacity: 0.7;
        }

        /* ページネーション */
        .pagination {
            margin-top: 16px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>PiGLy 体重管理</h1>

    {{-- ===== 検索フォーム ===== --}}
    <form method="GET" action="{{ route('dashboard') }}" class="search-area">
        <input type="date" name="from" value="{{ request('from') }}">
        <span>〜</span>
        <input type="date" name="to" value="{{ request('to') }}">
        <button type="submit" class="search-btn">検索</button>

        {{-- 検索中のみ表示 --}}
        @if(request()->filled('from') || request()->filled('to'))
            <a href="{{ route('dashboard') }}" class="reset-btn">リセット</a>
        @endif
    </form>

    {{-- ===== 検索結果表示 ===== --}}
    @if(request()->filled('from') || request()->filled('to'))
        <p class="result-text">
            {{ request('from') ?: '最初' }}
            〜
            {{ request('to') ?: '最新' }}
            の検索結果　{{ $totalCount }}件
        </p>
    @endif

    {{-- ===== サマリー ===== --}}
    <div class="summary">
        <div class="summary-box">
            <p>目標体重</p>
            <p class="summary-value">
                {{ $targetWeight !== null ? number_format($targetWeight, 1) : '-' }}kg
            </p>
        </div>

        <div class="summary-box">
            <p>目標まで</p>
            <p class="summary-value">
                {{ $diffToTarget !== null ? number_format($diffToTarget, 1) : '-' }}kg
            </p>
        </div>

        <div class="summary-box">
            <p>最新体重</p>
            <p class="summary-value">
                {{ $latestWeight !== null ? number_format($latestWeight, 1) : '-' }}kg
            </p>
        </div>
    </div>

    {{-- ===== 一覧 ===== --}}
    <table>
        <thead>
        <tr>
            <th>日付</th>
            <th>体重</th>
            <th>食事摂取カロリー</th>
            <th>運動時間</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @forelse($logs as $log)
            <tr>
                <td>{{ $log->date->format('Y/m/d') }}</td>
                <td>{{ number_format($log->weight, 1) }}kg</td>
                <td>{{ $log->calories }}cal</td>
                <td>
                    @php
                        $h = intdiv($log->exercise_minutes, 60);
                        $m = $log->exercise_minutes % 60;
                    @endphp
                    {{ sprintf('%02d:%02d', $h, $m) }}
                </td>
                <td>
                    <a href="/logs/{{ $log->id }}/edit" class="edit-btn">✏️</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">データがありません</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- ===== ページネーション ===== --}}
    <div class="pagination">
        {{ $logs->links() }}
    </div>

</div>

</body>
</html>
