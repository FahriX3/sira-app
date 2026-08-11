<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;

class DueController extends Controller
{
    /**
     * Display warga's dues history.
     */
    public function index()
    {
        $dues = auth()->user()->dues()->orderBy('month_year', 'desc')->paginate(12);

        $totalPaid   = auth()->user()->dues()->where('status', 'paid')->sum('amount');
        $totalUnpaid = auth()->user()->dues()->where('status', 'unpaid')->sum('amount');

        return view('warga.iuran.index', compact('dues', 'totalPaid', 'totalUnpaid'));
    }
}
