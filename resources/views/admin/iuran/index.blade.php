@extends('layouts.app')
@section('title', 'Iuran Bulanan')
@section('page-title', 'Iuran Bulanan')

@section('content')
    <div class="page-header">
        <div>
            <h2>Manajemen Iuran Bulanan</h2>
            <p>Kelola tagihan dan pembayaran iuran warga</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.iuran.export') }}" class="btn btn-outline" style="border-color: #10b981; color: #10b981;">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.iuran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Tagihan
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="filters-bar">
        <input type="text" name="search" class="form-input" placeholder="Cari nama atau NIK warga..."
               value="{{ request('search') }}">
        <input type="month" name="month" class="form-input" value="{{ request('month') }}" style="min-width: 180px;">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline"><i class="fas fa-search"></i> Filter</button>
    </form>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Warga</th>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tgl Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dues as $due)
                        <tr>
                            <td>{{ $due->id }}</td>
                            <td>
                                <strong>{{ $due->user->name }}</strong>
                                <br><small style="color: #9CA3AF;">{{ $due->user->nik }}</small>
                            </td>
                            <td>{{ $due->month_label }}</td>
                            <td style="font-weight: 600;">Rp {{ number_format($due->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($due->status === 'paid')
                                    <span class="badge badge-paid"><i class="fas fa-circle"></i> Lunas</span>
                                @else
                                    <span class="badge badge-unpaid"><i class="fas fa-circle"></i> Belum Bayar</span>
                                @endif
                            </td>
                            <td>{{ $due->payment_date ? $due->payment_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($due->status === 'unpaid')
                                    <form action="{{ route('admin.iuran.paid', $due) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-xs btn-success" title="Tandai Lunas">
                                            <i class="fas fa-check"></i> Lunas
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.iuran.unpaid', $due) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-xs btn-warning" title="Batalkan">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <h4>Belum ada data iuran</h4>
                                    <p>Tambahkan tagihan iuran untuk warga</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($dues->hasPages())
            <div class="card-footer">
                {{ $dues->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
