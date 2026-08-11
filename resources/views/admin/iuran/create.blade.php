@extends('layouts.app')
@section('title', 'Tambah Tagihan Iuran')
@section('page-title', 'Tambah Tagihan')

@section('content')
    <div class="page-header">
        <div>
            <h2>Tambah Tagihan Iuran</h2>
            <p>Buat tagihan iuran bulanan untuk warga</p>
        </div>
        <a href="{{ route('admin.iuran.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.iuran.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="user_id">Warga *</label>
                    <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Warga --</option>
                        @foreach($wargaList as $w)
                            <option value="{{ $w->id }}" {{ old('user_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->name }} — {{ $w->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="month_year">Bulan/Tahun *</label>
                        <input type="month" id="month_year" name="month_year" class="form-input @error('month_year') is-invalid @enderror"
                               value="{{ old('month_year', now()->format('Y-m')) }}" required>
                        @error('month_year')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="amount">Jumlah Iuran (Rp) *</label>
                        <input type="number" id="amount" name="amount" class="form-input @error('amount') is-invalid @enderror"
                               value="{{ old('amount', 50000) }}" min="1000" required>
                        @error('amount')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                    <a href="{{ route('admin.iuran.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
