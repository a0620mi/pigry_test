@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="card p-8 max-w-md w-full text-center">
    <div class="logo-text">PiGLy</div>
    <h2>ログイン</h2>
    @if (session('status'))
    <div class="alert success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="email">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力" required autocomplete="email">
            @error('email')
            {{ $message }}
            @enderror
        </div>

        <div class="password">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="パスワードを入力" required autocomplete="new-password" class="form_input">
            @error('password')
            {{ $message }}
            @enderror
        </div>

        <div class="flex items-center justify-center mb-4">
            <button type="submit" class="btn-primary">
                ログイン
            </button>
        </div>

        <div class="auth-footer-link">
            <a class="login" href="{{ route('register') }}">
                アカウント作成はこちら
            </a>
        </div>
    </form>
</div>
@endsection