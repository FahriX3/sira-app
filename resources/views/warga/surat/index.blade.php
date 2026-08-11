@extends('layouts.app')
@section('title', 'Surat Pengantar')
@section('page-title', 'Surat Pengantar')

@section('content')
    <div class="page-header">
        <div>
            <h2>Surat Pengantar Saya</h2>
            <p>Riwayat pengajuan surat pengantar</p>
        </div>
        <a href="{{ route('warga.surat.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajukan Surat Baru
        </a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $letter)
                        <tr>
                            <td>{{ $letter->id }}</td>
                            <td><strong>{{ $letter->letter_type }}</strong></td>
                            <td>{{ Str::limit($letter->purpose, 50) }}</td>
                            <td>{{ $letter->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($letter->status === 'pending')
                                    <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                                @elseif($letter->status === 'approved')
                                    <span class="badge badge-approved"><i class="fas fa-circle"></i> Disetujui</span>
                                @else
                                    <span class="badge badge-rejected"><i class="fas fa-circle"></i> Ditolak</span>
                                @endif
                                @if($letter->status === 'rejected' && $letter->rejection_reason)
                                    <div style="font-size: 12px; color: #991B1B; margin-top: 4px;">
                                        <i class="fas fa-info-circle"></i> {{ Str::limit($letter->rejection_reason, 50) }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-envelope-open-text"></i>
                                    <h4>Belum ada pengajuan surat</h4>
                                    <p>Ajukan surat pengantar pertama Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($letters->hasPages())
            <div class="card-footer">
                {{ $letters->links() }}
            </div>
        @endif
    </div>
@endsection
