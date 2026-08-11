<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik'      => ['required', 'string', 'size:16', 'unique:users,nik'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:20'],
            'address'  => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nik.required'       => 'NIK wajib diisi.',
            'nik.size'           => 'NIK harus 16 digit.',
            'nik.unique'         => 'NIK sudah terdaftar.',
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'phone.required'     => 'No. HP wajib diisi.',
            'address.required'   => 'Alamat wajib diisi.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nik'         => $validated['nik'],
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'address'     => $validated['address'],
            'role'        => 'warga',
            'is_verified' => false,
            'password'    => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Akun Anda akan diverifikasi oleh Pengurus RT. Silakan tunggu sebelum login.');
    }
}
