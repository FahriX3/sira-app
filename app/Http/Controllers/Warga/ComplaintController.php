<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display warga's complaints.
     */
    public function index()
    {
        $complaints = auth()->user()->complaints()->latest()->paginate(10);
        return view('warga.pengaduan.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        return view('warga.pengaduan.create');
    }

    /**
     * Store a new complaint.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'photo'       => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'title.required'       => 'Judul pengaduan wajib diisi.',
            'description.required' => 'Deskripsi pengaduan wajib diisi.',
            'description.min'      => 'Deskripsi minimal 20 karakter.',
            'photo.image'          => 'File harus berupa gambar.',
            'photo.mimes'          => 'Format gambar: JPEG, PNG, JPG.',
            'photo.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = auth()->user()->complaints()->create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'photo'       => $photoPath,
            'status'      => 'pending',
        ]);

        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\NewComplaintMail($complaint));
        }

        return redirect()->route('warga.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim. Pengurus RT akan menindaklanjuti laporan Anda.');
    }
}
