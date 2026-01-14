

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Weight Log</title>
</head>
<body>

  {{-- ✅ 更新フォーム（ここが1つ目のform） --}}
  <form method="POST" action="{{ route('logs.update', $log) }}">
    @csrf
    @method('PUT')

    <div>
      <label>日付</label>
      <input type="date" name="date" value="{{ old('date', $log->date->format('Y-m-d')) }}">
      @error('date') <div style="color:red;">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>体重</label>
      <input type="text" name="weight" value="{{ old('weight', number_format($log->weight,1)) }}"> kg
      @error('weight') <div style="color:red;">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>摂取カロリー</label>
      <input type="number" name="calories" value="{{ old('calories', $log->calories) }}"> cal
      @error('calories') <div style="color:red;">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>運動時間</label>
      <input type="time" name="exercise_time" value="{{ old('exercise_time', $exercise_time) }}">
      @error('exercise_time') <div style="color:red;">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>運動内容</label>
      <textarea name="exercise_content">{{ old('exercise_content', $log->exercise_content) }}</textarea>
      @error('exercise_content') <div style="color:red;">{{ $message }}</div> @enderror
    </div>

    <a href="{{ route('dashboard') }}">戻る</a>
    <button type="submit">更新</button>
  </form>

  {{-- ✅ 削除フォーム（更新formの外に置く！2つ目のform） --}}
  <form method="POST" action="{{ route('logs.destroy', $log) }}" onsubmit="return confirm('削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit">削除</button>
  </form>

</body>
</html>
