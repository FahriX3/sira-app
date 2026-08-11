@extends('layouts.app')
@section('title', 'Surat Pengantar')
@section('page-title', 'Surat Pengantar')

@section('content')
    <div class="page-header">
        <div>
            <h2>Manajemen Surat Pengantar</h2>
            <p>Kelola pengajuan surat pengantar dari warga</p>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="filters-bar">
        <input type="text" name="search" class="form-input" placeholder="Cari nama atau NIK warga..."
               value="{{ request('search') }}">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline"><i class="fas fa-search"></i> Cari</button>
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Warga</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $letter)
                        <tr>
                            <td>{{ $letter->id }}</td>
                            <td>
                                <strong>{{ $letter->user->name }}</strong>
                                <br><small style="color: #9CA3AF;">{{ $letter->user->nik }}</small>
                            </td>
                            <td>{{ $letter->letter_type }}</td>
                            <td>{{ Str::limit($letter->purpose, 40) }}</td>
                            <td>{{ $letter->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($letter->status === 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                                @elseif($letter->status === 'approved')
                                    <span class="badge badge-approved"><i class="fas fa-circle"></i> Disetujui</span>
                                @else
                                    <span class="badge badge-rejected"><i class="fas fa-circle"></i> Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.surat.show', $letter) }}" class="btn btn-xs btn-outline" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($letter->status === 'pending')
                                        <form action="{{ route('admin.surat.approve', $letter) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-xs btn-success" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button onclick="showRejectModal({{ $letter->id }})" class="btn btn-xs btn-danger" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    @if($letter->status === 'approved')
                                        <a href="{{ route('admin.surat.pdf', $letter) }}" class="btn btn-xs btn-info" title="Cetak PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-envelope-open-text"></i>
                                    <h4>Belum ada pengajuan surat</h4>
                                    <p>Pengajuan surat dari warga akan tampil di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($letters->hasPages())
            <div class="card-footer">
                {{ $letters->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div class="modal-overlay" id="rejectModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Tolak Pengajuan Surat</h3>
                <button class="modal-close" onclick="closeRejectModal()">&times;</button>
            </div>
            <form id="rejectForm" method="POST">
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
    function showRejectModal(letterId) {
        document.getElementById('rejectForm').action = '/admin/surat/' + letterId + '/reject';
        document.getElementById('rejectModal').classList.add('active');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
    }
</script>
@endsection
