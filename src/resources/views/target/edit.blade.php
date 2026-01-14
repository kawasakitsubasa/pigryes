<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>目標体重設定</title>
    <style>
        body{
            margin:0;
            font-family: sans-serif;
            background:#f5f5f5;
        }
        header{
            height:60px;
            background:#fff;
            border-bottom:1px solid #eee;
            display:flex;
            align-items:center;
            padding:0 24px;
        }
        .logo{
            color:#d88ad8;
            font-weight:700;
            letter-spacing:2px;
        }
        .wrap{
            display:flex;
            justify-content:center;
            align-items:center;
            height: calc(100vh - 60px);
        }
        .card{
            width: 420px;
            background:#fff;
            border-radius:8px;
            padding:32px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
            text-align:center;
        }
        .title{
            font-size:18px;
            font-weight:700;
            margin-bottom:18px;
        }
        .row{
            display:flex;
            align-items:center;
            gap:10px;
            justify-content:center;
            margin-bottom:10px;
        }
        input{
            width: 260px;
            height: 38px;
            border:1px solid #ddd;
            border-radius:4px;
            padding:0 10px;
        }
        .kg{ color:#555; }
        .error{
            color:#e74c3c;
            font-size:12px;
            text-align:left;
            margin:6px 0 0 45px;
        }
        .btns{
            display:flex;
            justify-content:center;
            gap:18px;
            margin-top:22px;
        }
        .btn{
            width:140px;
            height:42px;
            border-radius:8px;
            border:none;
            cursor:pointer;
            font-weight:700;
        }
        .btn-back{
            background:#e0e0e0;
            color:#333;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .btn-save{
            color:#fff;
            background: linear-gradient(90deg, #7f8cff, #ff8bd7);
        }
    </style>
</head>
<body>

<header>
    <div class="logo">PiGLy</div>
</header>

<div class="wrap">
    <div class="card">
        <div class="title">目標体重設定</div>

        <form method="POST" action="{{ route('target.update') }}">
            @csrf
            @method('PUT')

            <div class="row">
                <input
                    type="text"
                    name="target_weight"
                    value="{{ old('target_weight', optional($target)->target_weight) }}"
                    placeholder="46.5"
                >
                <span class="kg">kg</span>
            </div>

            @error('target_weight')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="btns">
                <a class="btn btn-back" href="{{ route('dashboard') }}">戻る</a>
                <button class="btn btn-save" type="submit">更新</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
