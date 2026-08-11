<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use Illuminate\Http\Request;

class LetterRequestController extends Controller
{
    /**
     * Display warga's letter requests.
     */
    public function index()
    {
        $letters = auth()->user()->letterRequests()->latest()->paginate(10);
        return view('warga.surat.index', compact('letters'));
    }

    /**
     * Show the form for creating a new letter request.
     */
    public function create()
    {
        $letterTypes = LetterRequest::letterTypes();
        return view('warga.surat.create', compact('letterTypes'));
    }

    /**
     * Store a new letter request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_type' => ['required', 'string'],
            'purpose'     => ['required', 'string', 'min:10'],
        ], [
            'letter_type.required' => 'Jenis surat wajib dipilih.',
            'purpose.required'     => 'Keperluan/alasan wajib diisi.',
            'purpose.min'          => 'Keperluan minimal 10 karakter.',
        ]);

        auth()->user()->letterRequests()->create([
            'letter_type' => $validated['letter_type'],
            'purpose'     => $validated['purpose'],
            'status'      => 'pending',
        ]);

        return redirect()->route('warga.surat.index')
            ->with('success', 'Pengajuan surat pengantar berhasil dikirim. Silakan tunggu persetujuan Pengurus RT.');
    }
}
