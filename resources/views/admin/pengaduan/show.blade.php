@extends('layouts.app')
@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')

@section('content')
    <div class="page-header">
        <div>
            <h2>Detail Pengaduan #{{ $complaint->id }}</h2>
            <p>Dilaporkan pada {{ $complaint->created_at->format('d F Y, H:i') }}</p>
        </div>
        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Detail Card -->
        <div>
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h3>{{ $complaint->title }}</h3>
                    @if($complaint->status === 'pending')
                        <span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span>
                    @elseif($complaint->status === 'process')
                        <span class="badge badge-process"><i class="fas fa-circle"></i> Diproses</span>
                    @else
                        <span class="badge badge-resolved"><i class="fas fa-circle"></i> Selesai</span>
                    @endif
                </div>
                <div class="card-body">
                    <div style="font-size: 15px; line-height: 1.8; margin-bottom: 24px;">
                        {{ $complaint->description }}
                    </div>

                    @if($complaint->photo)
                        <div style="margin-top: 20px;">
                            <div style="font-size: 12px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Foto Bukti</div>
                            <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Pengaduan"
                                 style="max-width: 100%; border-radius: 12px; border: 1px solid #E5E7EB;">
                        </div>
                    @endif
                </div>
                <div class="card-footer" style="display: flex; gap: 12px; justify-content: flex-end;">
                    @if($complaint->status === 'pending')
                        <form action="{{ route('admin.pengaduan.status', $complaint) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="process">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-cog"></i> Proses Pengaduan
                            </button>
                        </form>
                    @elseif($complaint->status === 'process')
                        <form action="{{ route('admin.pengaduan.status', $complaint) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="resolved">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="card">
            <div class="card-header">
                <h3>Pelapor</h3>
            </div>
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #4F46E5, #0EA5E9); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; margin: 0 auto 12px;">
                        {{ strtoupper(substr($complaint->user->name, 0, 1)) }}
                    </div>
                    <h4 style="font-size: 16px; font-weight: 700;">{{ $complaint->user->name }}</h4>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">NIK</div>
                        <div style="font-size: 14px; font-family: monospace;">{{ $complaint->user->nik }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">No. HP</div>
                        <div style="font-size: 14px;">{{ $complaint->user->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #9CA3AF; font-weight: 600;">Alamat</div>
                        <div style="font-size: 14px;">{{ $complaint->user->address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
