@extends('layouts.app')
@section('title', 'Data Warga')
@section('page-title', 'Data Warga')

@section('content')
    <div class="page-header">
        <div>
            <h2>Data Warga</h2>
            <p>Kelola data warga RT/RW</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.warga.export') }}" class="btn btn-outline" style="border-color: #10b981; color: #10b981;">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.warga.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Warga
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="filters-bar">
        <input type="text" name="search" class="form-input" placeholder="Cari nama, NIK, atau email..."
               value="{{ request('search') }}">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
            <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Belum Verifikasi</option>
        </select>
        <button type="submit" class="btn btn-sm btn-outline"><i class="fas fa-search"></i> Cari</button>
    </form>

    <!-- Table -->
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warga as $w)
                        <tr>
                            <td style="font-family: monospace; font-size: 13px;">{{ $w->nik }}</td>
                            <td><strong>{{ $w->name }}</strong></td>
                            <td>{{ $w->email }}</td>
                            <td>{{ $w->phone ?? '-' }}</td>
                            <td>
                                @if($w->is_verified)
                                    <span class="badge badge-verified"><i class="fas fa-circle"></i> Terverifikasi</span>
                                @else
                                    <span class="badge badge-unverified"><i class="fas fa-circle"></i> Belum Verifikasi</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <form action="{{ route('admin.warga.verify', $w) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        @if(!$w->is_verified)
                                            <button type="submit" class="btn btn-xs btn-success" title="Verifikasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-xs btn-warning" title="Batalkan Verifikasi">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </form>
                                    <a href="{{ route('admin.warga.edit', $w) }}" class="btn btn-xs btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.warga.destroy', $w) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus data warga ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h4>Belum ada data warga</h4>
                                    <p>Tambahkan warga baru atau tunggu registrasi warga</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($warga->hasPages())
            <div class="card-footer">
                {{ $warga->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
