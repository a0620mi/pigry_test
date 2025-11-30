<div x-data="{ show: @entangle('showModal') }" x-cloak>

    <div x-show="show" x-cloak>

        <div class="modal-overlay" wire:click="closeModal">
        </div>

        <div class="modal-panel">

            <form wire:submit.prevent="save">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">体重記録の追加</h3>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">日付</label>
                        <input type="date" id="date" wire:model.defer="date" class="form-input">
                        @error('date') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="weight">体重 (kg)</label>
                        <input type="number" step="0.1" id="weight" wire:model.defer="weight" class="form-input" placeholder="例: 46.5">
                        @error('weight') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="calories">食事摂取カロリー (cal)</label>
                        <input type="number" id="calories" wire:model.defer="calories" class="form-input" placeholder="例: 1200">
                        @error('calories') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="exercise_time">運動時間 (時:分)</label>
                        <input type="time" id="exercise_time" wire:model.defer="exercise_time" class="form-input">
                        @error('exercise_time') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove>保存する</span>
                        <span wire:loading>保存中...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>