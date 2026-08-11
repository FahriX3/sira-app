@extends('layouts.app')
@section('title', 'Detail Surat')
@section('page-title', 'Detail Surat Pengantar')

@section('content')
    <div class="page-header">
        <div>
            <h2>Detail Surat Pengantar #{{ $letter->id }}</h2>
            <p>Diajukan pada {{ $letter->created_at->format('d F Y, H:i') }}</p>
        </div>
        <a href="{{ route('admin.surat.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Detail Card -->
        <div class="card">
            <div class="card-header">
                <h3>Informasi Pengajuan</h3>
                @if($letter->status === 'pending')
                    <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                @elseif($letter->status === 'approved')
                    <span class="badge badge-approved"><i class="fas fa-circle"></i> Disetujui</span>
                @else
                    <span class="badge badge-rejected"><i class="fas fa-circle"></i> Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 12px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Jenis Surat</div>
                        <div style="font-size: 15px; font-weight: 600;">{{ $letter->letter_type }}</div>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Tanggal Pengajuan</div>
                        <div style="font-size: 15px;">{{ $letter->created_at->format('d F Y') }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div style="font-size: 12px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Keperluan / Alasan</div>
                    <div style="font-size: 15px; line-height: 1.7; background: #F9FAFB; padding: 16px; border-radius: 8px;">{{ $letter->purpose }}</div>
                </div>

                @if($letter->status === 'rejected' && $letter->rejection_reason)
                    <div class="alert alert-error">
                        <i class="fas fa-times-circle"></i>
                        <div>
                            <strong>Alasan Penolakan:</strong><br>
                            {{ $letter->rejection_reason }}
                        </div>
                    </div>
                @endif
            </div>
            @if($letter->status === 'pending')
                <div class="card-footer" style="display: flex; gap: 12px; justify-content: flex-end;">
                    <form action="{{ route('admin.surat.approve', $letter) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                    <button onclick="showRejectModal({{ $letter->id }})" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </div>
            @endif
            @if($letter->status === 'approved')
                <div class="card-footer" style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('admin.surat.pdf', $letter) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </a>
                </div>
            @endif
        </div>

        <!-- Data Pemohon -->
        <div class="card">
            <div class="card-header">
                <h3>Data Pemohon</h3>
            </div>
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #4F46E5, #0EA5E9); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; margin: 0 auto 12px;">
                        {{ strtoupper(substr($letter->user->name, 0, 1)) }}
                    </div>
                    <h4 style="font-size: 16px; font-weight: 700;">{{ $letter->user->name }}</h4>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">NIK</div>
                        <div style="font-size: 14px; font-family: monospace;">{{ $letter->user->nik }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">Email</div>
                        <div style="font-size: 14px;">{{ $letter->user->email }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">No. HP</div>
                        <div style="font-size: 14px;">{{ $letter->user->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">Alamat</div>
                        <div style="font-size: 14px;">{{ $letter->user->address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal-overlay" id="rejectModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Tolak Pengajuan Surat</h3>
                <button class="modal-close" onclick="closeRejectModal()">&times;</button>
            </div>
            <form action="{{ route('admin.surat.reject', $letter) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Alasan Penolakan *</label>
                        <textarea name="rejection_reason" class="form-textarea" placeholder="Tuliskan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function showRejectModal() {
        document.getElementById('rejectModal').classList.add('active');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
    }
</script>
@endsection
