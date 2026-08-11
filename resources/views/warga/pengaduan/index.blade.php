@extends('layouts.app')
@section('title', 'Pengaduan Saya')
@section('page-title', 'Pengaduan')

@section('content')
    <div class="page-header">
        <div>
            <h2>Pengaduan Saya</h2>
            <p>Riwayat laporan pengaduan Anda</p>
        </div>
        <a href="{{ route('warga.pengaduan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Kirim Pengaduan Baru
        </a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->id }}</td>
                            <td><strong>{{ $complaint->title }}</strong></td>
                            <td>{{ Str::limit($complaint->description, 40) }}</td>
                            <td>
                                @if($complaint->photo)
                                    <a href="{{ asset('storage/' . $complaint->photo) }}" target="_blank" style="color: #4F46E5;">
                                        <i class="fas fa-image"></i> Lihat
                                    </a>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-bullhorn"></i>
                                    <h4>Belum ada pengaduan</h4>
                                    <p>Kirim pengaduan pertama Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($complaints->hasPages())
            <div class="card-footer">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
@endsection
