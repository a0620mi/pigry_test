@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
@endsection

@section('header')
<header id="page-header" class="main-header">
    <h1 class="logo-text">PiGLy</h1>
    <nav class="user-nav">
        <a href="/weight_logs/goal_setting" id="btn-target-setting" class="nav-button setting-button">
            <i class="icon-setting">⚙️</i> 目標体重設定
        </a>
        <form method="POST" route="/logout" class="logout-form">
            @csrf
            <button type="submit" class="nav-button logout-button">
                <i class="icon-logout">🚪</i> ログアウト
            </button>
        </form>
    </nav>
</header>
@endsection

@section('content')
<main id="main-content" class="tracker-page">
    <section id="summary-section" class="summary-cards-container">
        <div class="summary-card target-card">
            <h2 class="card-title">目標体重</h2>
            <div class="card-value-group">
                <span id="target-weight" class="card-value">{{ number_format($lastedTarget->target_weight ?? 0, 1) }}</span>
                <span class="card-unit">kg</span>
            </div>
        </div>
        <div class="summary-card diff-card">
            <h2 class="card-title">目標まで</h2>
            <div class="card-value-group">
                <span id="weight-difference" class="card-value">
                    {{ number_format(abs($weightDiff), 1) }}
                </span>
                <span class="card-unit">kg</span>
            </div>
        </div>
        <div class="summary-card latest-card">
            <h2 class="card-title">最新体重</h2>
            <div class="card-value-group">
                <span id="latest-weight" class="card-value">{{ number_format($latestLog->weight ?? 0, 1) }}</span>
                <span class="card-unit">kg</span>
            </div>
        </div>
    </section>
</main>
<section id="control-section" class="control-panel">
    <form id="search-form" class="search-controls" method="GET" action="{{ route('weight_logs') }}">
        @csrf <div class="date-input-group start-date-group">
            <label for="start-date" class="sr-only">開始日</label>
            <input type="date" id="start-date" name="start_date" class="date-input"
                placeholder="年/月/日" value="{{ $startDate ?? '' }}">
        </div>
        <span class="date-separator">〜</span>
        <div class="date-input-group end-date-group">
            <label for="end-date" class="sr-only">終了日</label>
            <input type="date" id="end-date" name="end_date" class="date-input"
                placeholder="年/月/日" value="{{ $endDate ?? '' }}">
        </div>
        <button type="submit" class="search-button">検索</button>
    </form>
    <button
        id="btn-add-data"
        onclick="Livewire.emitTo('add-weight-log-modal', 'openModalEvent')"
        class="action-button add-data-button">
        データ追加
    </button>
</section>
@livewire('add-weight-log-modal')

<section id="log-table-section" class="data-record-container">
    <div class="responsive-table-wrapper">
        <table id="weight-log-table" class="log-data-table">
            <thead>
                <tr class="table-header-row">
                    <th class="header-date">日付</th>
                    <th class="header-weight">体重</th>
                    <th class="header-calories">食事摂取カロリー</th>
                    <th class="header-exercise-time">運動時間</th>
                    <th class="header-actions"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr class="data-row log-row">
                    <td class="data-date">{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</td>
                    <td class="data-weight">{{ number_format($log->weight, 1) }}<span class="unit">kg</span></td>
                    <td class="data-calories">{{ number_format($log->calories) }}<span class="unit">cal</span></td>
                    <td class="data-exercise">{{ substr($log->exercise_time, 0, 5) ?? '00:00' }}</td>
                    <td class="data-actions">
                        <a href="{{ '/weight_logs/' . $log->id }}" class="edit-button" title="詳細を表示">
                            📝
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="no-date-row">
                    <td colspan="5" class="text-center">記録されたデータはありません。</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-container">
        @if(isset($logs))
        {{ $logs->links() }}
        @endif
    </div>
</section>
@endsection