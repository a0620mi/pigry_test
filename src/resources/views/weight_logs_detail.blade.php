@extends('weight_logs')

@section('content')
<main class="detail-page-container">
    <div class="detail-card">
        <header class="detail-header">
            <h1 class="page-title">Weight Log</h1>
        </header>
        <form method="POST" action="{{ '/weight_logs/' . $log->id . '/update' }}" class="log-edit-form">
            @csrf
            <div class="form-section">
                <div class="form-group">
                    <label for="date">日付</label>
                    <input type="date" id="date" name="date" class="form-input"
                        value="{{ $log->date }}" required>
                </div>
                <div class="form-group">
                    <label for="weight">体重</label>
                    <div class="input-with-unit">
                        <input type="number" step="0.1" id="weight" name="weight" class="form-input"
                            value="{{ $log->weight }}" required>
                        <span class="unit-label">kg</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="calories">摂取カロリー</label>
                    <div class="input-with-unit">
                        <input type="number" id="calories" name="calories" class="form-input"
                            value="{{ $log->calories }}">
                        <span class="unit-label">cal</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exercise_time">運動時間</label>
                    <input type="time" id="exercise_time" name="exercise_time" class="form-input"
                        value="{{ substr($log->exercise_time, 0, 5) }}">
                </div>
                <div class="form-group">
                    <label for="exercise_content">運動内容</label>
                    <textarea id="exercise_content" name="exercise_content" class="form-textarea"
                        placeholder="運動内容を追記">{{ $log->exercise_content }}</textarea>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('weight_logs') }}" class="btn btn-secondary action-back">戻る</a>

                <button type="submit" class="btn btn-primary action-update">更新</button>
            </div>
        </form>

        <form method="POST" action="{{ '/weight_logs/' . $log->id . '/delete' }}" class="delete-form">
            @csrf
            <button type="submit" class="btn-icon action-delete" title="記録を削除">
                <i class="icon-trash">🗑️</i>
            </button>
        </form>
    </div>
</main>
@endsection