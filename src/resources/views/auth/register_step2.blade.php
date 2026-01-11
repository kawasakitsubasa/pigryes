<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>STEP2 体重入力</title>
</head>
<body>

<h1>新規会員登録</h1>

<form method="POST" action="/register/step2">
    @csrf

    <div>
        <label>現在の体重</label><br>
        <input type="number" step="0.1" name="current_weight" value="{{ old('current_weight') }}">
        @error('current_weight')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <div>
        <label>目標の体重</label><br>
        <input type="number" step="0.1" name="target_weight" value="{{ old('target_weight') }}">
        @error('target_weight')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <button type="submit">アカウント作成</button>
</form>

</body>
</html>
