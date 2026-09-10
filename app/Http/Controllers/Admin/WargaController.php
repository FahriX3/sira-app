<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WargaController extends Controller
{
    /**
     * Display a listing of warga.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'warga');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_verified', $request->status === 'verified');
        }

        $warga = $query->latest()->paginate(10);

        return view('admin.warga.index', compact('warga'));
    }

    /**
     * Show the form for creating a new warga.
     */
    public function create()
    {
        return view('admin.warga.create');
    }

    /**
     * Store a newly created warga.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'      => ['required', 'string', 'size:16', 'unique:users,nik'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:20'],
            'address'  => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'nik'         => $validated['nik'],
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'address'     => $validated['address'],
            'role'        => 'warga',
            'is_verified' => true,
            'password'    => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified warga.
     */
    public function edit(User $warga)
    {
        return view('admin.warga.edit', compact('warga'));
    }

    /**
     * Update the specified warga.
     */
    public function update(Request $request, User $warga)
    {
        $validated = $request->validate([
            'nik'     => ['required', 'string', 'size:16', 'unique:users,nik,' . $warga->id],
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $warga->id],
            'phone'   => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
        ]);

        $warga->update($validated);

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']]);
            $warga->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified warga.
     */
    public function destroy(User $warga)
    {
        $warga->delete();

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }

    /**
     * Toggle verification status of a warga.
     */
    public function verify(User $warga)
    {
        $warga->update(['is_verified' => !$warga->is_verified]);

        $status = $warga->is_verified ? 'diverifikasi' : 'dibatalkan verifikasinya';

        return redirect()->route('admin.warga.index')
            ->with('success', "Akun warga {$warga->name} berhasil {$status}.");
    }

    /**
     * Export warga data to CSV.
     */
    public function export()
    {
        $fileName = 'data_warga_' . date('Ymd_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'NIK', 'Nama', 'Email', 'No. HP', 'Alamat', 'Status Verifikasi', 'Bergabung Pada']);

            $warga = User::where('role', 'warga')->get();

            foreach ($warga as $index => $w) {
                fputcsv($file, [
                    $index + 1,
                    "'" . $w->nik, // Prefix with quote to prevent excel treating it as number and stripping zeros
                    $w->name,
                    $w->email,
                    $w->phone ? "'" . $w->phone : '-',
                    $w->address,
                    $w->is_verified ? 'Terverifikasi' : 'Belum Verifikasi',
                    $w->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }
}
