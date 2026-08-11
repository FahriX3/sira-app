@extends('layouts.app')
@section('title', 'Dashboard Warga')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Welcome -->
    <div class="card" style="margin-bottom: 24px; background: linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #0EA5E9 100%); color: #fff; border: none;">
        <div class="card-body" style="padding: 28px 32px;">
            <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 4px;">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h3>
            <p style="opacity: 0.8; font-size: 15px;">Berikut ringkasan layanan Anda di SIRA.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon indigo">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="stat-card-info">
                <h4>Total Surat</h4>
                <div class="stat-value">{{ $stats['surat_total'] }}</div>
                <div class="stat-sub">{{ $stats['surat_pending'] }} pending, {{ $stats['surat_approved'] }} disetujui</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon yellow">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="stat-card-info">
                <h4>Pengaduan Aktif</h4>
                <div class="stat-value">{{ $stats['pengaduan_pending'] }}</div>
                <div class="stat-sub">dari {{ $stats['pengaduan_total'] }} total pengaduan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon red">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-card-info">
                <h4>Iuran Belum Bayar</h4>
                <div class="stat-value">{{ $stats['iuran_unpaid'] }}</div>
                <div class="stat-sub">Total Rp {{ number_format($stats['iuran_total_unpaid'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Recent Letters -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-envelope-open-text" style="color: #4F46E5; margin-right: 8px;"></i> Surat Terbaru</h3>
                <a href="{{ route('warga.surat.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($recentLetters as $letter)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #F3F4F6;">
                        <div>
                            <div style="font-weight: 600; font-size: 14px;">{{ $letter->letter_type }}</div>
                            <div style="font-size: 12px; color: #9CA3AF;">{{ $letter->created_at->format('d M Y') }}</div>
                        </div>
                        @if($letter->status === 'pending')
                            <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                        @elseif($letter->status === 'approved')
                            <span class="badge badge-approved"><i class="fas fa-circle"></i> Disetujui</span>
                        @else
                            <span class="badge badge-rejected"><i class="fas fa-circle"></i> Ditolak</span>
                        @endif
                    </div>
                @empty
                    <div class="empty-state" style="padding: 24px 0;">
                        <i class="fas fa-envelope-open-text" style="font-size: 32px;"></i>
                        <p>Belum ada pengajuan surat</p>
                    </div>
                @endforelse
            </div>
            <div class="card-footer" style="text-align: center;">
                <a href="{{ route('warga.surat.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Ajukan Surat Baru
                </a>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bullhorn" style="color: #F59E0B; margin-right: 8px;"></i> Pengaduan Terbaru</h3>
                <a href="{{ route('warga.pengaduan.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($recentComplaints as $complaint)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #F3F4F6;">
                        <div>
                            <div style="font-weight: 600; font-size: 14px;">{{ Str::limit($complaint->title, 30) }}</div>
                            <div style="font-size: 12px; color: #9CA3AF;">{{ $complaint->created_at->format('d M Y') }}</div>
                        </div>
                        @if($complaint->status === 'pending')
                            <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                        @elseif($complaint->status === 'process')
                            <span class="badge badge-process"><i class="fas fa-circle"></i> Diproses</span>
                        @else
                            <span class="badge badge-resolved"><i class="fas fa-circle"></i> Selesai</span>
                        @endif
                    </div>
                @empty
                    <div class="empty-state" style="padding: 24px 0;">
                        <i class="fas fa-bullhorn" style="font-size: 32px;"></i>
                        <p>Belum ada pengaduan</p>
                    </div>
                @endforelse
            </div>
            <div class="card-footer" style="text-align: center;">
                <a href="{{ route('warga.pengaduan.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Kirim Pengaduan Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Current Due -->
    @if($currentDue)
        <div class="card" style="margin-top: 24px;">
            <div class="card-header">
                <h3><i class="fas fa-money-bill-wave" style="color: #EF4444; margin-right: 8px;"></i> Tagihan Iuran</h3>
            </div>
            <div class="card-body" style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 15px; font-weight: 600;">Iuran {{ $currentDue->month_label }}</div>
                    <div style="font-size: 24px; font-weight: 800; color: #EF4444; margin-top: 4px;">Rp {{ number_format($currentDue->amount, 0, ',', '.') }}</div>
                </div>
                <span class="badge badge-unpaid" style="font-size: 14px; padding: 8px 20px;">
                    <i class="fas fa-circle"></i> Belum Bayar
                </span>
            </div>
            <div class="card-footer">
                <a href="{{ route('warga.iuran.index') }}" class="btn btn-sm btn-outline">Lihat Semua Tagihan</a>
            </div>
        </div>
    @endif
@endsection
