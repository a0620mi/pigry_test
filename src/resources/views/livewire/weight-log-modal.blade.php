<div X-data="{ open: @entangle('showModal') }">
    <div x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="modal-overlay"
        style="display: none;"
        wire:click="closeModal">
    </div>
    <div x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="modal-panel"
        style="display: none;">

        @if ($log)
        <div class="modal-header">
            <h3 class="modal-title">{{ $log->date }} の記録詳細</h3>
            <button type="button" class="close-button" wire:click="closeModal">
                &times;
            </button>
        </div>

        <div class="modal-body">
            <p><strong>日付:</strong>{{ number_format($logs->date) }}</p>
            <p><strong>体重:</strong> {{ number_format($log->weight, 1) }} kg</p>
            <p><strong>カロリー:</strong> {{ number_format($log->calories) }} cal</p>
            <p><strong>運動時間:</strong> {{ substr($log->exercise_time, 0, 5) ?? '00:00' }}</p>
            <p><strong>運動内容:</strong>{{ exercise_content($logs->content) }}</p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="closeModal">閉じる</button>
            {{-- 将来的な編集・削除ボタンを追加する場所 --}}
            <a href="#" class="btn btn-primary">編集画面へ</a>
        </div>
        @else
        <p>データがロードされていません。</p>
        @endif
    </div>
</div>

@once
@push('css')
<style>
    .modal-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        /* 他の要素より手前に */
    }

    .modal-panel {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        max-width: 500px;
        width: 90%;
        padding: 20px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .modal-title {
        margin: 0;
        font-size: 1.5em;
    }

    .close-button {
        background: none;
        border: none;
        font-size: 1.5em;
        cursor: pointer;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #6a1b9a;
        color: white;
    }

    .btn-secondary {
        background-color: #ccc;
        color: #333;
    }
</style>
@endpush
@endonce