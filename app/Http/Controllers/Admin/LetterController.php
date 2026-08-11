<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{
    /**
     * Display a listing of letter requests.
     */
    public function index(Request $request)
    {
        $query = LetterRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $letters = $query->latest()->paginate(10);

        return view('admin.surat.index', compact('letters'));
    }

    /**
     * Display the specified letter request.
     */
    public function show(LetterRequest $letter)
    {
        $letter->load('user');
        return view('admin.surat.show', compact('letter'));
    }

    /**
     * Approve a letter request.
     */
    public function approve(LetterRequest $letter)
    {
        $letter->update(['status' => 'approved']);

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat pengantar berhasil disetujui.');
    }

    /**
     * Reject a letter request.
     */
    public function reject(Request $request, LetterRequest $letter)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string'],
        ]);

        $letter->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.surat.index')
            ->with('success', 'Surat pengantar ditolak.');
    }

    /**
     * Generate PDF for approved letter.
     */
    public function printPdf(LetterRequest $letter)
    {
        $letter->load('user');

        $pdf = Pdf::loadView('surat.pdf', compact('letter'));

        return $pdf->download('surat-pengantar-' . $letter->user->name . '-' . now()->format('Ymd') . '.pdf');
    }
}
