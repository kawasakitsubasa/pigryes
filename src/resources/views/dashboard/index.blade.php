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

        /* ===== ヘッダー ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #ff7ac9;
        }

        .header-right {
            display: flex;
            gap: 12px;
        }

        .header-btn {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background: #fff;
            text-decoration: none;
            color: #333;
            cursor: pointer;
        }

        .header-btn:hover {
            background: #f5f5f5;
        }

        /* ===== メイン ===== */
        .container {
            max-width: 1000px;
            margin: 24px auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
        }

        /* ===== 検索＋追加 ===== */
        .search-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .search-area {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-area input[type="date"] {
            padding: 6px;
        }

        .search-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            background: #888;
            color: #fff;
        }

        .reset-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: #fff;
            text-decoration: none;
            color: #333;
        }

        .add-btn {
            padding: 10px 18px;
            border-radius: 12px;
            background: linear-gradient(90deg, #8aa3ff, #ff7ac9);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
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
            border-bottom: 2px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #faf6ff;
        }

        .edit-btn {
            font-size: 18px;
            text-decoration: none;
        }

        .pagination {
            margin-top: 16px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

{{-- ===== ヘッダー ===== --}}
<header class="header">
    <span class="logo">PiGLy</span>

    <div class="header-right">
        <a href="{{ route('target.edit') }}" class="header-btn">⚙ 目標体重設定</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="header-btn">🚪 ログアウト</button>
        </form>
    </div>
</header>

{{-- ===== メイン ===== --}}
<div class="container">

    {{-- 検索＋追加 --}}
    <div class="search-wrapper">
        <form method="GET" action="{{ route('dashboard') }}" class="search-area">
            <input type="date" name="from" value="{{ request('from') }}">
            <span>〜</span>
            <input type="date" name="to" value="{{ request('to') }}">
            <button type="submit" class="search-btn">検索</button>

            @if(request()->filled('from') || request()->filled('to'))
                <a href="{{ route('dashboard') }}" class="reset-btn">リセット</a>
            @endif
        </form>

        <a href="{{ route('logs.create') }}" class="add-btn">データ追加</a>
    </div>

    {{-- 検索結果 --}}
    @if(request()->filled('from') || request()->filled('to'))
        <p class="result-text">
            {{ request('from') }}〜{{ request('to') }}の検索結果 {{ $totalCount }}件
        </p>
    @endif

    {{-- サマリー --}}
    <div class="summary">
        <div class="summary-box">
            <p>目標体重</p>
            <p class="summary-value">{{ number_format($targetWeight,1) }}kg</p>
        </div>

        <div class="summary-box">
            <p>目標まで</p>
            <p class="summary-value">{{ number_format($diffToTarget,1) }}kg</p>
        </div>

        <div class="summary-box">
            <p>最新体重</p>
            <p class="summary-value">{{ number_format($latestWeight,1) }}kg</p>
        </div>
    </div>

    {{-- 一覧 --}}
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
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->date->format('Y/m/d') }}</td>
                <td>{{ number_format($log->weight,1) }}kg</td>
                <td>{{ $log->calories }}cal</td>
                <td>{{ sprintf('%02d:%02d', intdiv($log->exercise_minutes,60), $log->exercise_minutes%60) }}</td>
                <td><a href="{{ route('logs.edit', $log) }}" class="edit-btn">✏️</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $logs->links() }}

</div>
</body>
</html>


