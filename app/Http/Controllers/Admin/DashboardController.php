<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LetterRequest;
use App\Models\Complaint;
use App\Models\Due;
use Carbon\Carbon;

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

        // Chart Data: Pengaduan by Status
        $complaintStats = Complaint::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        $chartComplaint = [
            'pending'  => $complaintStats['pending'] ?? 0,
            'process'  => $complaintStats['process'] ?? 0,
            'resolved' => $complaintStats['resolved'] ?? 0,
        ];

        // Chart Data: Surat by Type
        $letterStats = LetterRequest::selectRaw('letter_type, count(*) as count')
            ->groupBy('letter_type')
            ->pluck('count', 'letter_type')
            ->toArray();

        // Chart Data: Iuran last 6 months
        $chartDueMonths = [];
        $chartDuePaid = [];
        $chartDueUnpaid = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthValue = $date->format('Y-m'); // e.g. "2026-09"
            $chartDueMonths[] = $date->translatedFormat('M Y'); // e.g. "Sep 2026"

            $paid = Due::where('month_year', $monthValue)->where('status', 'paid')->sum('amount');
            $unpaid = Due::where('month_year', $monthValue)->where('status', 'unpaid')->sum('amount');

            $chartDuePaid[] = $paid;
            $chartDueUnpaid[] = $unpaid;
        }

        $chartDue = [
            'labels' => $chartDueMonths,
            'paid'   => $chartDuePaid,
            'unpaid' => $chartDueUnpaid,
        ];

        $recentLetters    = LetterRequest::with('user')->latest()->take(5)->get();
        $recentComplaints = Complaint::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recentLetters', 
            'recentComplaints', 
            'chartComplaint', 
            'letterStats', 
            'chartDue'
        ));
    }
}
