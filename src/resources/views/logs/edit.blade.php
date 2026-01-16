<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Weight Log</title>
  <style>
    body{
      margin:0;
      font-family: sans-serif;
      background:#fff;
      color:#222;
    }

    /* ===== Header ===== */
    .header{
      height:64px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:0 28px;
      border-bottom:1px solid #eee;
      background:#fff;
    }
    .brand{
      font-weight:700;
      font-size:24px;
      letter-spacing:1px;
      color:#e79ad6; /* PiGLyっぽいピンク */
    }
    .header-actions{
      display:flex;
      gap:10px;
      align-items:center;
    }
    .topbtn{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 12px;
      border:1px solid #ddd;
      border-radius:6px;
      background:#fff;
      cursor:pointer;
      font-size:13px;
      color:#333;
      text-decoration:none;
    }
    .topbtn .icon{
      font-size:14px;
      opacity:.8;
    }

    /* ===== Layout ===== */
    .wrap{
      padding:48px 18px;
      display:flex;
      justify-content:center;
    }
    .card{
      width:740px;
      max-width:95vw;
      background:#fff;
      border-radius:10px;
      padding:48px 56px;
      box-sizing:border-box;
      border:1px solid #f2f2f2;
    }
    .title{
      font-size:20px;
      font-weight:700;
      text-align:center;
      margin:0 0 22px;
    }

    .form-row{
      margin:18px 0;
    }
    .label{
      font-size:13px;
      margin:0 0 8px;
      color:#333;
    }
    .input{
      width:100%;
      padding:12px 12px;
      border:1px solid #e6e6e6;
      border-radius:6px;
      outline:none;
      box-sizing:border-box;
      background:#fff;
    }
    .input:focus{
      border-color:#cfcfcf;
    }

    .inline{
      display:flex;
      align-items:center;
      gap:10px;
    }
    .unit{
      color:#777;
      font-size:13px;
      white-space:nowrap;
    }

    .textarea{
      width:100%;
      min-height:140px;
      resize:none;
      padding:12px;
      border:1px solid #e6e6e6;
      border-radius:6px;
      outline:none;
      box-sizing:border-box;
    }

    .error{
      color:#ff4d4d;
      font-size:12px;
      margin-top:6px;
      line-height:1.4;
    }

    /* ===== Buttons ===== */
    .actions{
      margin-top:26px;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:18px;
      position:relative;
    }
    .btn{
      min-width:180px;
      padding:12px 18px;
      border-radius:10px;
      border:none;
      cursor:pointer;
      font-weight:700;
      font-size:14px;
    }
    .btn-back{
      background:#e6e6e6;
      color:#333;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      justify-content:center;
    }
    .btn-submit{
      color:#fff;
      background: linear-gradient(90deg, #8aa3ff, #ff7ac9);
    }

    /* Trash icon button (右下の赤いゴミ箱) */
    .trash-form{
      position:static;
      margin-left: 10px;

    }
    .trash-btn{
      width:46px;
      height:46px;
      border:none;
      background:transparent;
      cursor:pointer;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .trash-btn svg{
      width:22px;
      height:22px;
      fill:#ff3b30;
    }
    .trash-btn:hover svg{
      filter: brightness(0.95);
    }
  </style>
</head>
<body>

  <header class="header">
    <div class="brand">PiGLy</div>

    <div class="header-actions">
      <a class="topbtn" href="{{ route('target.edit') }}">
        <span class="icon">⚙</span> 目標体重設定
      </a>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="topbtn" type="submit">
          <span class="icon">🚪</span> ログアウト
        </button>
      </form>
    </div>
  </header>

  <main class="wrap">
    <div class="card">
      <h1 class="title">Weight Log</h1>

      {{-- 更新フォーム --}}
      <form method="POST" action="{{ route('logs.update', $log) }}">
       @csrf
       @method('PUT')
      <input type="hidden" name="redirect_to" value="{{ request('redirect_to', route('dashboard')) }}">


        <div class="form-row">
          <div class="label">日付</div>
          <input class="input" type="date" name="date" value="{{ old('date', optional($log->date)->format('Y-m-d')) }}">
          @error('date') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
          <div class="label">体重</div>
          <div class="inline">
            <input class="input" type="text" name="weight" value="{{ old('weight', number_format((float)$log->weight, 1)) }}">
            <span class="unit">kg</span>
          </div>
          @error('weight') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
          <div class="label">摂取カロリー</div>
          <div class="inline">
            <input class="input" type="number" name="calories" value="{{ old('calories', $log->calories) }}">
            <span class="unit">cal</span>
          </div>
          @error('calories') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
          <div class="label">運動時間</div>
          <input class="input" type="time" name="exercise_time" value="{{ old('exercise_time', $exercise_time ?? '00:00') }}">
          @error('exercise_time') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
          <div class="label">運動内容</div>
          <textarea class="textarea" name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content', $log->exercise_content) }}</textarea>
          @error('exercise_content') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
           <a class="btn btn-back" href="{{ route('dashboard') }}">戻る</a>
           <button class="btn btn-submit" type="submit">更新</button>
        </div>

        </form> {{-- ✅ 更新フォームをここで閉じる --}}

{{-- ✅ 削除フォームは更新フォームの外 --}}
        <form class="trash-form" method="POST" action="{{ route('logs.destroy', $log) }}"
              onsubmit="return confirm('削除しますか？');">
          @csrf
          @method('DELETE')
          <button class="trash-btn" type="submit" aria-label="削除">
             <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9 3h6l1 2h4v2H4V5h4l1-2zm1 7h2v9h-2v-9zm4 0h2v9h-2v-9zM7 10h2v9H7v-9zm-1 12h12a2 2 0 0 0 2-2V9H4v11a2 2 0 0 0 2 2z"/>
             </svg>
          </button>
        </form>


      </form>
    </div>
  </main>

</body>
</html>

