@extends('weight_logs')

@section('content')
<main class="goal-setting-page-container">
    <div class="setting-card">
        <h1 class="page-title">目標体重設定</h1>

        <form method="POST" action="/weight_logs/goal_setting/update" class="goal-setting-form">
            @csrf

            <div class="form-group-inline">
                <input type="number" step="0.1" name="target_weight" class="form-input"
                    value="{{ number_format($lastedTarget->target_weight ?? 0, 1) }}" required>
                <span class="unit-label">kg</span>
            </div>

            <div class="form-actions">
                <a href="/weight_logs" class="btn btn-secondary action-back">戻る</a>

                <button type="submit" class="btn btn-primary action-update">更新</button>
            </div>
        </form>
    </div>
</main>
@endsection
