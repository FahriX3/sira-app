@extends('layouts.guest')
@section('title', 'Registrasi')

@section('content')
    <h2>Daftar Akun Warga</h2>
    <p class="auth-subtitle">Buat akun baru untuk mengakses layanan RT/RW</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="nik">NIK (Nomor Induk Kependudukan)</label>
            <input type="text" id="nik" name="nik" class="form-input @error('nik') is-invalid @enderror"
                   value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required>
            @error('nik')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Nama sesuai KTP" required>
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="nama@email.com" required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">No. HP</label>
                <input type="text" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                @error('phone')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Alamat Lengkap</label>
            <textarea id="address" name="address" class="form-textarea @error('address') is-invalid @enderror"
                      placeholder="Jl. ..., RT/RW, Kelurahan" required>{{ old('address') }}</textarea>
            @error('address')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror"
                       placeholder="Min. 8 karakter" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                       placeholder="Ulangi password" required>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-user-plus"></i> Daftar Sekarang
        </button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
@endsection
