<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>

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
            width: 520px;
            max-width: 92vw;
            background:#fff;
            border-radius: 16px;
            padding: 48px 56px;
            box-shadow: 0 12px 40px rgba(0,0,0,.08);
            text-align:center;
        }

        /* タイトル */
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
            margin: 6px 0 10px;
        }
        .step{
            font-size: 12px;
            color:#999;
            margin-bottom: 26px;
        }

        /* フォーム */
        .form{ text-align:left; }

        .row{ margin-bottom: 16px; }

        .label{
            display:block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
            color:#333;
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

        .error{
            margin-top: 6px;
            font-size: 12px;
            color: #ff5a6a;
        }

        /* ボタン */
        .btn-primary{
            width: 180px;
            height: 40px;
            border: none;
            border-radius: 10px;
            color:#fff;
            font-weight: 700;
            cursor:pointer;
            display:block;
            margin: 20px auto 10px;
            background: linear-gradient(90deg, #8aa3ff, #ff7ac9);
            box-shadow: 0 8px 18px rgba(255, 122, 200, .25);
        }

        /* リンク */
        .link-wrap{ text-align:center; margin-top: 10px; }

        .link{
            font-size: 12px;
            color:#3b82f6;
            text-decoration:none;
        }
        .link:hover{ text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-bg">
    <div class="auth-card">
        <div class="brand">PiGLy</div>
        <div class="page-title">新規会員登録</div>
        <div class="step">STEP1　アカウント情報の登録</div>

        <form class="form" method="POST" action="/register">
            @csrf

            <div class="row">
                <label class="label">お名前</label>
                <input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="名前を入力">
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="row">
                <label class="label">メールアドレス</label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">

                {{-- 必須/形式などのバリデーションエラー --}}
                @error('email')
                   <p class="error">メールアドレスは「ユーザー名@ドメイン」形式で入力してください</p>
                @enderror

            </div>

            <div class="row">
                <label class="label">パスワード</label>
                <input class="input" type="password" name="password" placeholder="パスワードを入力">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn-primary" type="submit">次に進む</button>

            <div class="link-wrap">
                <a class="link" href="/login">ログインはこちら</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
