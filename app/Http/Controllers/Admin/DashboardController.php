<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LetterRequest;
use App\Models\Complaint;
use App\Models\Due;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'total_warga'       => User::where('role', 'warga')->count(),
            'warga_pending'     => User::where('role', 'warga')->where('is_verified', false)->count(),
            'surat_pending'     => LetterRequest::where('status', 'pending')->count(),
            'pengaduan_pending' => Complaint::whereIn('status', ['pending', 'process'])->count(),
            'total_iuran'       => Due::where('status', 'paid')->sum('amount'),
            'iuran_belum_bayar' => Due::where('status', 'unpaid')->count(),
        ];

        $recentLetters    = LetterRequest::with('user')->latest()->take(5)->get();
        $recentComplaints = Complaint::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentLetters', 'recentComplaints'));
    }
}
