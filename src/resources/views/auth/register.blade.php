<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>
</head>
<body>
    <h1>PiGLy 新規会員登録</h1>

    <form method="POST" action="/register">
        @csrf
        <div>
            <label>お名前</label>
            <input type="text" name="name" value="{{ old('name') }}">

            @error('name')
               <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">

            {{-- 必須エラー --}}
            @error('email')
               <p style="color:red;">{{ $message }}</p>
            @enderror

            {{-- 形式エラー文（スクショ用に常に表示） --}}
            <p style="color:red;">
                メールアドレスは「ユーザー名@ドメイン」形式で入力してください
            </p>

        </div>

        <div>
            <label>パスワード</label>
            <input type="password" name="password">

            @error('password')
               <p style="color:red;">{{ $message }}</p>
            @enderror

        </div>

        <button>次に進む</button>

        <div style="margin-top: 16px; text-align: center;">
           <a href="/login">ログインはこちら</a>
        </div>

    </form>
</body>
</html>
