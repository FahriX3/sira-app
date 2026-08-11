<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\Complaint;
use App\Models\Due;

class DashboardController extends Controller
{
    /**
     * Show warga dashboard with summary.
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'surat_total'       => $user->letterRequests()->count(),
            'surat_pending'     => $user->letterRequests()->where('status', 'pending')->count(),
            'surat_approved'    => $user->letterRequests()->where('status', 'approved')->count(),
            'pengaduan_total'   => $user->complaints()->count(),
            'pengaduan_pending' => $user->complaints()->whereIn('status', ['pending', 'process'])->count(),
            'iuran_unpaid'      => $user->dues()->where('status', 'unpaid')->count(),
            'iuran_total_unpaid'=> $user->dues()->where('status', 'unpaid')->sum('amount'),
        ];

        $recentLetters    = $user->letterRequests()->latest()->take(3)->get();
        $recentComplaints = $user->complaints()->latest()->take(3)->get();
        $currentDue       = $user->dues()->where('status', 'unpaid')->oldest()->first();

        return view('warga.dashboard', compact('stats', 'recentLetters', 'recentComplaints', 'currentDue'));
    }
}
