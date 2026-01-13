<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>PiGLy ログイン</h1>

    <form method="POST" action="/login">
       @csrf
        <!-- メール -->
    <div>
        <label>メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}">

        @error('email')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <!-- パスワード -->
    <div>
        <label>パスワード</label>
        <input type="password" name="password">

        @error('password')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <!-- ログイン失敗 -->
    @error('login')
        <p style="color:red; text-align:center;">{{ $message }}</p>
    @enderror

    <button type="submit">ログイン</button>
</form>

<div style="text-align:center; margin-top:16px;">
    <a href="/register">アカウント作成はこちら</a>
</div>
</body>
</html>
