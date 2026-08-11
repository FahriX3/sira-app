@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-info">
                <h4>Total Warga</h4>
                <div class="stat-value">{{ $stats['total_warga'] }}</div>
                <div class="stat-sub">{{ $stats['warga_pending'] }} menunggu verifikasi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon yellow">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="stat-card-info">
                <h4>Surat Pending</h4>
                <div class="stat-value">{{ $stats['surat_pending'] }}</div>
                <div class="stat-sub">menunggu persetujuan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon red">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="stat-card-info">
                <h4>Pengaduan Aktif</h4>
                <div class="stat-value">{{ $stats['pengaduan_pending'] }}</div>
                <div class="stat-sub">perlu ditindaklanjuti</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon green">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-card-info">
                <h4>Total Iuran Terkumpul</h4>
                <div class="stat-value">Rp {{ number_format($stats['total_iuran'], 0, ',', '.') }}</div>
                <div class="stat-sub">{{ $stats['iuran_belum_bayar'] }} tagihan belum lunas</div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Recent Letter Requests -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-envelope-open-text" style="color: #4F46E5; margin-right: 8px;"></i> Surat Terbaru</h3>
                <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Warga</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLetters as $letter)
                            <tr>
                                <td>
                                    <strong>{{ $letter->user->name }}</strong>
                                </td>
                                <td>{{ $letter->letter_type }}</td>
                                <td>
                                    @if($letter->status === 'pending')
                                        <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                                    @elseif($letter->status === 'approved')
                                        <span class="badge badge-approved"><i class="fas fa-circle"></i> Disetujui</span>
                                    @else
                                        <span class="badge badge-rejected"><i class="fas fa-circle"></i> Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; color: #9CA3AF;">Belum ada pengajuan surat</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bullhorn" style="color: #EF4444; margin-right: 8px;"></i> Pengaduan Terbaru</h3>
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Warga</th>
                            <th>Judul</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentComplaints as $complaint)
                            <tr>
                                <td>
                                    <strong>{{ $complaint->user->name }}</strong>
                                </td>
                                <td>{{ Str::limit($complaint->title, 30) }}</td>
                                <td>
                                    @if($complaint->status === 'pending')
                                        <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                                    @elseif($complaint->status === 'process')
                                        <span class="badge badge-process"><i class="fas fa-circle"></i> Diproses</span>
                                    @else
                                        <span class="badge badge-resolved"><i class="fas fa-circle"></i> Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center; color: #9CA3AF;">Belum ada pengaduan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
