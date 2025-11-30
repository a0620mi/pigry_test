@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register2.css') }}">
@endsection

@section('content')
<div class="card p-8 max-w-md w-full text-center">
    <div class="logo-text">PiGLy</div>
    <h2>新規会員登録</h2>
    <p>STEP2 体重データの入力</p>
    @if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('register.step2.post') }}" class="auth-form">
        @csrf
        <div class="form-group">
            <div class="weight_log">
                <label for="weight_log">現在の体重</label>
                <input id="current_weight" type="number" step="0.1" name="current_weight" placeholder="現在の体重を入力" value="{{ old('current_weight') }}" required class="form-input">
                @error('weight_log')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="weight_goal">
                <label for="weight_goal">目標の体重</label>
                <input id="weight_goal" type="text" step="0.1" name="weight_goal" placeholder="目標の体重を入力" required value="{{ old('target_weight') }}">
                @error('weight_goal')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-center mb-4">
            <button type="submit" class="btn-primary">
                アカウントを作成
            </button>
        </div>
    </form>
</div>
@endsection