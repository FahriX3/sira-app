@extends('layouts.app')
@section('title', 'Pengaduan Warga')
@section('page-title', 'Pengaduan Warga')

@section('content')
    <div class="page-header">
        <div>
            <h2>Manajemen Pengaduan</h2>
            <p>Kelola laporan pengaduan dari warga</p>
        </div>
        <a href="{{ route('admin.pengaduan.export') }}" class="btn btn-outline" style="border-color: #10b981; color: #10b981;">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" class="filters-bar">
        <input type="text" name="search" class="form-input" placeholder="Cari judul pengaduan atau nama warga..."
               value="{{ request('search') }}">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="process" {{ request('status') === 'process' ? 'selected' : '' }}>Diproses</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Selesai</option>
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
                        <th>Judul Pengaduan</th>
                        <th>Foto</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->id }}</td>
                            <td><strong>{{ $complaint->user->name }}</strong></td>
                            <td>{{ Str::limit($complaint->title, 35) }}</td>
                            <td>
                                @if($complaint->photo)
                                    <i class="fas fa-image" style="color: #4F46E5;"></i>
                                @else
                                    <span style="color: #D1D5DB;">-</span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($complaint->status === 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                                @elseif($complaint->status === 'process')
                                    <span class="badge badge-process"><i class="fas fa-circle"></i> Diproses</span>
                                @else
                                    <span class="badge badge-resolved"><i class="fas fa-circle"></i> Selesai</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.pengaduan.show', $complaint) }}" class="btn btn-xs btn-outline" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($complaint->status === 'pending')
                                        <form action="{{ route('admin.pengaduan.status', $complaint) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="process">
                                            <button type="submit" class="btn btn-xs btn-info" title="Proses">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                        </form>
                                    @elseif($complaint->status === 'process')
                                        <form action="{{ route('admin.pengaduan.status', $complaint) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="resolved">
                                            <button type="submit" class="btn btn-xs btn-success" title="Selesai">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-bullhorn"></i>
                                    <h4>Belum ada pengaduan</h4>
                                    <p>Pengaduan dari warga akan tampil di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($complaints->hasPages())
            <div class="card-footer">
                {{ $complaints->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
