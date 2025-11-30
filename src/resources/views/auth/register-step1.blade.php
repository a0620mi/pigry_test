@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="card p-8 max-w-md w-full text-center">
    <div class="logo-text">PiGLy</div>
    <h2>新規会員登録</h2>
    <p>STEP1 アカウント情報の登録</p>
    @if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('register.post') }}" class="auth-form">
        @csrf
        <div class="form_group">
            <label for="name">お名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="名前を入力" required autocomplete="name">
            @error('name')
            {{ $message }}
            @enderror
        </div>

        <div class="form_group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" placeholder="メールアドレスを入力" required autocomplete="email">
            @error('email')
            {{ $message }}
            @enderror
        </div>

        <div class="form_group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="パスワードを入力" required autocomplete="new-password">
            @error('password')
            {{ $message }}
            @enderror
        </div>

        <div class="flex items-center justify-center mb-4">
            <button type="submit" class="btn-primary">
                次に進む
            </button>
        </div>

        <div class="auth-footer-link">
            <a class="login" href="{{ route('login') }}">
                ログインはこちら
            </a>
        </div>
    </form>
</div>
@endsection