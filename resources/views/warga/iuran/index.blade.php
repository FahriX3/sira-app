@extends('layouts.app')
@section('title', 'Iuran Bulanan')
@section('page-title', 'Iuran Bulanan')

@section('content')
    <div class="page-header">
        <div>
            <h2>Iuran Bulanan Saya</h2>
            <p>Riwayat tagihan dan pembayaran iuran</p>
        </div>
    </div>

    <!-- Summary -->
    <div class="stats-grid" style="grid-template-columns: 1fr 1fr;">
        <div class="stat-card">
            <div class="stat-card-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-info">
                <h4>Total Sudah Dibayar</h4>
                <div class="stat-value" style="color: #059669;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon red">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="stat-card-info">
                <h4>Total Belum Dibayar</h4>
                <div class="stat-value" style="color: #EF4444;">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dues as $due)
                        <tr>
                            <td><strong>{{ $due->month_label }}</strong></td>
                            <td style="font-weight: 600;">Rp {{ number_format($due->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($due->status === 'paid')
                                    <span class="badge badge-paid"><i class="fas fa-circle"></i> Lunas</span>
                                @else
                                    <span class="badge badge-unpaid"><i class="fas fa-circle"></i> Belum Bayar</span>
                                @endif
                            </td>
                            <td>{{ $due->payment_date ? $due->payment_date->format('d F Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <h4>Belum ada data iuran</h4>
                                    <p>Tagihan iuran Anda akan tampil di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($dues->hasPages())
            <div class="card-footer">
                {{ $dues->links() }}
            </div>
        @endif
    </div>

    <div style="background: #FEF3C7; border-radius: 12px; padding: 16px 20px; margin-top: 20px;">
        <div style="display: flex; align-items: flex-start; gap: 12px;">
            <i class="fas fa-info-circle" style="color: #D97706; margin-top: 2px;"></i>
            <div style="font-size: 13px; color: #92400E; line-height: 1.6;">
                <strong>Informasi Pembayaran:</strong> Untuk melakukan pembayaran iuran, silakan hubungi Pengurus RT secara langsung. 
                Setelah pembayaran diterima, status iuran Anda akan diperbarui oleh Pengurus RT.
            </div>
        </div>
    </div>
@endsection
