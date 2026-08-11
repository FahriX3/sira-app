@extends('layouts.app')
@section('title', 'Kirim Pengaduan')
@section('page-title', 'Kirim Pengaduan')

@section('content')
    <div class="page-header">
        <div>
            <h2>Kirim Pengaduan Baru</h2>
            <p>Laporkan masalah lingkungan RT/RW</p>
        </div>
        <a href="{{ route('warga.pengaduan.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('warga.pengaduan.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="title">Judul Pengaduan *</label>
                    <input type="text" id="title" name="title" class="form-input @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="Contoh: Lampu Jalan Padam" required>
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi Pengaduan *</label>
                    <textarea id="description" name="description" class="form-textarea @error('description') is-invalid @enderror"
                              placeholder="Jelaskan masalah secara detail, termasuk lokasi dan kondisi yang terjadi..." rows="6"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Minimal 20 karakter. Jelaskan lokasi dan kondisi masalah secara detail.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="photo">Foto Bukti (Opsional)</label>
                    <input type="file" id="photo" name="photo" class="form-input @error('photo') is-invalid @enderror"
                           accept="image/jpeg,image/png,image/jpg"
                           style="padding: 8px;">
                    @error('photo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Format: JPEG, PNG, JPG. Maksimal 2MB.</div>
                </div>

                <!-- Preview -->
                <div id="photoPreview" style="display: none; margin-bottom: 20px;">
                    <img id="previewImage" src="" alt="Preview" style="max-width: 300px; border-radius: 12px; border: 1px solid #E5E7EB;">
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('warga.pengaduan.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('photo').addEventListener('change', function(e) {
        const preview = document.getElementById('photoPreview');
        const image = document.getElementById('previewImage');

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                image.src = ev.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection
