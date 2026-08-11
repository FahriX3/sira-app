@extends('layouts.app')
@section('title', 'Ajukan Surat')
@section('page-title', 'Ajukan Surat Pengantar')

@section('content')
    <div class="page-header">
        <div>
            <h2>Ajukan Surat Pengantar</h2>
            <p>Isi form di bawah untuk mengajukan surat pengantar</p>
        </div>
        <a href="{{ route('warga.surat.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('warga.surat.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="letter_type">Jenis Surat *</label>
                    <select id="letter_type" name="letter_type" class="form-select @error('letter_type') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach($letterTypes as $type)
                            <option value="{{ $type }}" {{ old('letter_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('letter_type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="purpose">Keperluan / Alasan *</label>
                    <textarea id="purpose" name="purpose" class="form-textarea @error('purpose') is-invalid @enderror"
                              placeholder="Jelaskan keperluan atau alasan pengajuan surat pengantar ini..." rows="5"
                              required>{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Minimal 10 karakter. Jelaskan secara detail keperluan surat Anda.</div>
                </div>

                <div style="background: #EEF2FF; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <i class="fas fa-info-circle" style="color: #4F46E5; margin-top: 2px;"></i>
                        <div style="font-size: 13px; color: #3730A3; line-height: 1.6;">
                            <strong>Informasi:</strong> Setelah diajukan, surat Anda akan diproses oleh Pengurus RT. 
                            Anda akan menerima notifikasi status persetujuan melalui dashboard.
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('warga.surat.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Ajukan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
