@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" style="box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s;">
            <div class="stat-card-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-info">
                <h4>Total Warga</h4>
                <div class="stat-value">{{ $stats['total_warga'] }}</div>
                <div class="stat-sub">{{ $stats['warga_pending'] }} menunggu verifikasi</div>
            </div>
        </div>

        <div class="stat-card" style="box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s;">
            <div class="stat-card-icon yellow">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="stat-card-info">
                <h4>Surat Pending</h4>
                <div class="stat-value">{{ $stats['surat_pending'] }}</div>
                <div class="stat-sub">menunggu persetujuan</div>
            </div>
        </div>

        <div class="stat-card" style="box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s;">
            <div class="stat-card-icon red">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="stat-card-info">
                <h4>Pengaduan Aktif</h4>
                <div class="stat-value">{{ $stats['pengaduan_pending'] }}</div>
                <div class="stat-sub">perlu ditindaklanjuti</div>
            </div>
        </div>

        <div class="stat-card" style="box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: transform 0.2s;">
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

    <!-- Charts Section -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
        <!-- Chart: Iuran 6 Bulan Terakhir -->
        <div class="card" style="grid-column: span 2;">
            <div class="card-header">
                <h3><i class="fas fa-chart-bar" style="color: #10B981; margin-right: 8px;"></i> Tren Iuran (6 Bulan Terakhir)</h3>
            </div>
            <div style="padding: 20px; height: 300px;">
                <canvas id="chartIuran"></canvas>
            </div>
        </div>

        <!-- Chart: Status Pengaduan -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie" style="color: #EF4444; margin-right: 8px;"></i> Status Pengaduan</h3>
            </div>
            <div style="padding: 20px; height: 300px; display: flex; justify-content: center;">
                <canvas id="chartPengaduan"></canvas>
            </div>
        </div>

        <!-- Chart: Jenis Surat -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie" style="color: #4F46E5; margin-right: 8px;"></i> Permintaan Surat</h3>
            </div>
            <div style="padding: 20px; height: 300px; display: flex; justify-content: center;">
                <canvas id="chartSurat"></canvas>
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

@section('scripts')
<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Styling Defaults
    function getChartColors() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        return {
            text: isDark ? '#9CA3AF' : '#6B7280',
            grid: isDark ? '#374151' : '#E5E7EB'
        };
    }
    
    let colors = getChartColors();
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = colors.text;
    
    // --- Chart Iuran (Bar) ---
    const ctxIuran = document.getElementById('chartIuran').getContext('2d');
    const dataIuran = @json($chartDue);
    
    const chartIuran = new Chart(ctxIuran, {
        type: 'bar',
        data: {
            labels: dataIuran.labels.reverse(), // Reverse to show oldest to newest
            datasets: [
                {
                    label: 'Lunas',
                    data: dataIuran.paid.reverse(),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 4
                },
                {
                    label: 'Belum Bayar',
                    data: dataIuran.unpaid.reverse(),
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: { color: colors.grid }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: colors.grid },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // --- Chart Pengaduan (Pie) ---
    const ctxPengaduan = document.getElementById('chartPengaduan').getContext('2d');
    const dataPengaduan = @json($chartComplaint);
    
    const chartPengaduan = new Chart(ctxPengaduan, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai'],
            datasets: [{
                data: [dataPengaduan.pending, dataPengaduan.process, dataPengaduan.resolved],
                backgroundColor: [
                    '#F59E0B', // Yellow
                    '#3B82F6', // Blue
                    '#10B981'  // Green
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // --- Chart Surat (Doughnut) ---
    const ctxSurat = document.getElementById('chartSurat').getContext('2d');
    const dataSurat = @json($letterStats);
    
    // Prepare labels and data for Surat
    const suratLabels = Object.keys(dataSurat);
    const suratData = Object.values(dataSurat);
    
    // Default data if empty
    if (suratLabels.length === 0) {
        suratLabels.push('Belum ada data');
        suratData.push(1);
    }
    
    const chartSurat = new Chart(ctxSurat, {
        type: 'doughnut',
        data: {
            labels: suratLabels,
            datasets: [{
                data: suratData,
                backgroundColor: [
                    '#6366F1', '#EC4899', '#8B5CF6', '#14B8A6', '#F97316'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Handle Theme Changes
    window.addEventListener('themeChanged', function() {
        const newColors = getChartColors();
        
        // Update global defaults
        Chart.defaults.color = newColors.text;
        
        // Update Iuran Chart
        chartIuran.options.scales.x.grid.color = newColors.grid;
        chartIuran.options.scales.y.grid.color = newColors.grid;
        chartIuran.update();
        
        // Update Pie/Doughnut Charts
        chartPengaduan.update();
        chartSurat.update();
    });
});
</script>
@endsection
