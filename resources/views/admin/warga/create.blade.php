@extends('layouts.app')
@section('title', 'Tambah Warga')
@section('page-title', 'Tambah Warga')

@section('content')
    <div class="page-header">
        <div>
            <h2>Tambah Warga Baru</h2>
            <p>Isi data warga untuk mendaftarkan akun baru</p>
        </div>
        <a href="{{ route('admin.warga.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.warga.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nik">NIK (Nomor Induk Kependudukan) *</label>
                    <input type="text" id="nik" name="nik" class="form-input @error('nik') is-invalid @enderror"
                           value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required>
                    @error('nik')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Nama sesuai KTP" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="email">Email *</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="nama@email.com" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">No. HP *</label>
                        <input type="text" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                        @error('phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Alamat Lengkap *</label>
                    <textarea id="address" name="address" class="form-textarea @error('address') is-invalid @enderror"
                              placeholder="Jl. ..., RT/RW, Kelurahan" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror"
                           placeholder="Min. 8 karakter" required>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Password minimal 8 karakter. Akun warga akan langsung terverifikasi.</div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Warga
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
