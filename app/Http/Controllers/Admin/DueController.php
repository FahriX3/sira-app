<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Due;
use App\Models\User;
use Illuminate\Http\Request;

class DueController extends Controller
{
    /**
     * Display a listing of dues.
     */
    public function index(Request $request)
    {
        $query = Due::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->where('month_year', $request->month);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $dues = $query->latest()->paginate(10);

        return view('admin.iuran.index', compact('dues'));
    }

    /**
     * Show the form for creating a new due.
     */
    public function create()
    {
        $wargaList = User::where('role', 'warga')
            ->where('is_verified', true)
            ->orderBy('name')
            ->get();

        return view('admin.iuran.create', compact('wargaList'));
    }

    /**
     * Store a newly created due.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => ['required', 'exists:users,id'],
            'month_year' => ['required', 'string'],
            'amount'     => ['required', 'integer', 'min:1000'],
        ]);

        // Check if due already exists for this user & month
        $exists = Due::where('user_id', $validated['user_id'])
            ->where('month_year', $validated['month_year'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tagihan untuk warga ini pada bulan tersebut sudah ada.')
                ->withInput();
        }

        Due::create([
            'user_id'    => $validated['user_id'],
            'month_year' => $validated['month_year'],
            'amount'     => $validated['amount'],
            'status'     => 'unpaid',
        ]);

        return redirect()->route('admin.iuran.index')
            ->with('success', 'Tagihan iuran berhasil ditambahkan.');
    }

    /**
     * Mark a due as paid.
     */
    public function markPaid(Due $due)
    {
        $due->update([
            'status'       => 'paid',
            'payment_date' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Iuran berhasil dicatat sebagai lunas.');
    }

    /**
     * Mark a due as unpaid.
     */
    public function markUnpaid(Due $due)
    {
        $due->update([
            'status'       => 'unpaid',
            'payment_date' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Status iuran dikembalikan menjadi belum bayar.');
    }
}
