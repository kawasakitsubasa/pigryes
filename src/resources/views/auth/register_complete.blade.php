<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
    <style>
        body{
            margin:0;
            font-family: sans-serif;
        }

        /* 背景グラデーション */
        .bg{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background: linear-gradient(135deg, #f6c1ff, #ffd6c9);
        }

        /* 中央カード */
        .card{
            width:420px;
            max-width:90vw;
            background:#fff;
            border-radius:14px;
            padding:40px 32px;
            text-align:center;
            box-shadow: 0 10px 30px rgba(0,0,0,.15);
        }

        .logo{
            font-size:32px;
            font-weight:700;
            color:#e79ad6;
            letter-spacing:2px;
            margin-bottom:12px;
        }

        .title{
            font-size:20px;
            font-weight:700;
            margin-bottom:24px;
        }

        .message{
            font-size:14px;
            color:#666;
            margin-bottom:32px;
            line-height:1.6;
        }

        .btn{
            display:inline-block;
            padding:12px 32px;
            border-radius:10px;
            font-weight:700;
            text-decoration:none;
            color:#fff;
            background: linear-gradient(90deg, #8aa3ff, #ff7ac9);
        }
    </style>
</head>
<body>

<div class="bg">
    <div class="card">
        <div class="logo">PiGLy</div>

        <div class="title">登録完了！</div>

        <div class="message">
            アカウントの作成が完了しました。<br>
            ログインして体重管理を始めましょう。
        </div>

        <a href="{{ route('login') }}" class="btn">
            ログインへ
        </a>
    </div>
</div>

</body>
</html>

