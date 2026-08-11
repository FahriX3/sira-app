@extends('layouts.app')
@section('title', 'Edit Warga')
@section('page-title', 'Edit Warga')

@section('content')
    <div class="page-header">
        <div>
            <h2>Edit Data Warga</h2>
            <p>{{ $warga->name }} — {{ $warga->nik }}</p>
        </div>
        <a href="{{ route('admin.warga.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.warga.update', $warga) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="nik">NIK *</label>
                    <input type="text" id="nik" name="nik" class="form-input @error('nik') is-invalid @enderror"
                           value="{{ old('nik', $warga->nik) }}" maxlength="16" required>
                    @error('nik')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror"
                           value="{{ old('name', $warga->name) }}" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="email">Email *</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email', $warga->email) }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">No. HP *</label>
                        <input type="text" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $warga->phone) }}" required>
                        @error('phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Alamat Lengkap *</label>
                    <textarea id="address" name="address" class="form-textarea @error('address') is-invalid @enderror"
                              required>{{ old('address', $warga->address) }}</textarea>
                    @error('address')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Kosongkan jika tidak ingin mengubah password.</div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
