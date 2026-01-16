<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規会員登録 STEP2</title>

    <style>
        body { margin: 0; font-family: sans-serif; }

        /* 背景 */
        .auth-bg{
            min-height: 100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 40px 16px;
            background: linear-gradient(135deg, #f3d6ff 0%, #ffd6e6 45%, #ffb3d9 100%);
        }

        /* カード */
        .auth-card{
            width: 560px;
            max-width: 92vw;
            background:#fff;
            border-radius: 16px;
            padding: 48px 56px;
            box-shadow: 0 12px 40px rgba(0,0,0,.08);
            text-align:center;
        }

        .brand{
            font-size: 40px;
            letter-spacing: .2em;
            color: #d18cff;
            font-weight: 300;
            margin-bottom: 6px;
        }

        .page-title{
            font-size: 18px;
            color:#444;
            margin: 6px 0 18px;
        }

        .step{
            font-size: 12px;
            color:#777;
            margin-bottom: 24px;
        }

        .form{ text-align:left; }

        .row{ margin-bottom: 16px; }

        .label{
            display:block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
            color:#333;
        }

        .inline{
            display:flex;
            align-items:center;
            gap: 10px;
        }

        .input{
            width: 100%;
            height: 42px;
            border: 1px solid #e7e7e7;
            border-radius: 6px;
            padding: 0 12px;
            outline: none;
            font-size: 14px;
        }

        .input::placeholder{ color:#c9c9c9; }

        .unit{
            font-size: 13px;
            color:#777;
            white-space: nowrap;
        }

        .error{
            margin-top: 6px;
            font-size: 12px;
            color: #ff5a6a;
        }

        .btn-primary{
            width: 220px;
            height: 40px;
            border: none;
            border-radius: 10px;
            color:#fff;
            font-weight: 700;
            cursor:pointer;
            display:block;
            margin: 22px auto 0;
            background: linear-gradient(90deg, #8aa3ff, #ff7ac9);
            box-shadow: 0 8px 18px rgba(255, 122, 200, .25);
        }
    </style>
</head>

<body>
<div class="auth-bg">
    <div class="auth-card">
        <div class="brand">PiGLy</div>
        <div class="page-title">新規会員登録</div>
        <div class="step">STEP2 体重データの入力</div>

        {{-- action は君のルート名/URLに合わせて変えてOK --}}
        <form class="form" method="POST" action="{{ route('register.step2.store') }}">
            @csrf

            <div class="row">
                <label class="label">現在の体重</label>
                <div class="inline">
                    <input class="input" type="text" name="current_weight"
                           value="{{ old('current_weight') }}"
                           placeholder="現在の体重を入力">
                    <span class="unit">kg</span>
                </div>
                @error('current_weight')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="row">
                <label class="label">目標の体重</label>
                <div class="inline">
                    <input class="input" type="text" name="target_weight"
                           value="{{ old('target_weight') }}"
                           placeholder="目標の体重を入力">
                    <span class="unit">kg</span>
                </div>
                @error('target_weight')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn-primary" type="submit">アカウント作成</button>
        </form>
    </div>
</div>
</body>
</html>

