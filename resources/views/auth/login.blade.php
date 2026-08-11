@extends('layouts.guest')
@section('title', 'Login')

@section('content')
    <h2>Selamat Datang!</h2>
    <p class="auth-subtitle">Masuk ke akun SIRA Anda</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror"
                   placeholder="Masukkan password" required>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="remember-row">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-sign-in-alt"></i> Masuk
        </button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </div>
@endsection
