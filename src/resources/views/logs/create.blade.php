<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Weight Logを追加</title>
    <style>
        body { margin:0; font-family:sans-serif; }
        .overlay{
            min-height:100vh;
            background: rgba(0,0,0,.35);
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 24px;
        }
        .modal{
            width: 860px;
            max-width: 95vw;
            background:#fff;
            border-radius: 10px;
            padding: 28px 32px;
            box-shadow: 0 10px 30px rgba(0,0,0,.2);
        }
        .title{ font-size: 20px; font-weight: 700; margin-bottom: 18px; }
        .row{ margin-bottom: 14px; }
        .label{ display:flex; align-items:center; gap:10px; font-weight:600; margin-bottom: 6px; }
        .required{
            font-size: 12px;
            color: #fff;
            background: #ff5b5b;
            padding: 2px 8px;
            border-radius: 999px;
        }
        .input{
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }
        .unit{ margin-left: 8px; color:#777; }
        .inline{
            display:flex;
            align-items:center;
            gap: 8px;
        }
        .error{ color:#ff4d4d; font-size: 12px; margin-top: 6px; }
        .actions{
            margin-top: 22px;
            display:flex;
            justify-content:center;
            gap: 18px;
        }
        .btn{
            min-width: 160px;
            padding: 12px 18px;
            border-radius: 10px;
            border: none;
            cursor:pointer;
            font-weight: 700;
        }
        .btn-back{
            background: #e6e6e6;
            color: #333;
        }
        .btn-submit{
            color: #fff;
            background: linear-gradient(90deg, #8aa3ff, #ff7ac9);
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="modal">
        <div class="title">Weight Logを追加</div>

        <form method="POST" action="{{ route('logs.store') }}">
            @csrf

            <div class="row">
                <div class="label">日付 <span class="required">必須</span></div>
                <input class="input" type="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
                @error('date') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="label">体重 <span class="required">必須</span></div>
                <div class="inline">
                    <input class="input" style="max-width: 320px;" type="text" name="weight" value="{{ old('weight') }}" placeholder="50.0">
                    <span class="unit">kg</span>
                </div>
                @error('weight') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="label">摂取カロリー <span class="required">必須</span></div>
                <div class="inline">
                    <input class="input" style="max-width: 320px;" type="number" name="calories" value="{{ old('calories') }}" placeholder="1200">
                    <span class="unit">cal</span>
                </div>
                @error('calories') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="label">運動時間 <span class="required">必須</span></div>
                <input class="input" style="max-width: 320px;" type="time" name="exercise_time" value="{{ old('exercise_time', '00:00') }}">
                @error('exercise_time') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="label">運動内容</div>
                <textarea class="input" name="exercise_content" rows="6" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                @error('exercise_content') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="actions">
                <a class="btn btn-back" href="{{ route('dashboard') }}" style="text-align:center; line-height: 24px; text-decoration:none; display:inline-block;">
                    戻る
                </a>
                <button class="btn btn-submit" type="submit">登録</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
