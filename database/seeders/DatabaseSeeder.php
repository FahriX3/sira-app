<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Due;
use App\Models\Complaint;
use App\Models\LetterRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin (Pengurus RT)
        $admin = User::create([
            'nik'         => '3201010101010001',
            'name'        => 'Fahri Mandriva',
            'email'       => 'fahrimandriva138@gmail.com',
            'phone'       => '081234567890',
            'address'     => 'Jl. Merdeka No. 1, RT 005/RW 002',
            'role'        => 'admin',
            'is_verified' => true,
            'password'    => Hash::make('password'),
        ]);

        // Warga 1 - Verified
        $warga1 = User::create([
            'nik'         => '3201010101010002',
            'name'        => 'Budi Santoso',
            'email'       => 'warga1@sira.test',
            'phone'       => '081234567891',
            'address'     => 'Jl. Merdeka No. 10, RT 005/RW 002',
            'role'        => 'warga',
            'is_verified' => true,
            'password'    => Hash::make('password'),
        ]);

        // Warga 2 - Verified
        $warga2 = User::create([
            'nik'         => '3201010101010003',
            'name'        => 'Siti Nurhaliza',
            'email'       => 'warga2@sira.test',
            'phone'       => '081234567892',
            'address'     => 'Jl. Merdeka No. 15, RT 005/RW 002',
            'role'        => 'warga',
            'is_verified' => true,
            'password'    => Hash::make('password'),
        ]);

        // Warga 3 - Verified
        $warga3 = User::create([
            'nik'         => '3201010101010004',
            'name'        => 'Agus Pratama',
            'email'       => 'warga3@sira.test',
            'phone'       => '081234567893',
            'address'     => 'Jl. Kenanga No. 5, RT 005/RW 002',
            'role'        => 'warga',
            'is_verified' => true,
            'password'    => Hash::make('password'),
        ]);

        // Warga 4 - Belum Verified
        $warga4 = User::create([
            'nik'         => '3201010101010005',
            'name'        => 'Dewi Lestari',
            'email'       => 'warga4@sira.test',
            'phone'       => '081234567894',
            'address'     => 'Jl. Kenanga No. 8, RT 005/RW 002',
            'role'        => 'warga',
            'is_verified' => false,
            'password'    => Hash::make('password'),
        ]);

        // Warga 5 - Belum Verified
        User::create([
            'nik'         => '3201010101010006',
            'name'        => 'Rina Marlina',
            'email'       => 'warga5@sira.test',
            'phone'       => '081234567895',
            'address'     => 'Jl. Melati No. 3, RT 005/RW 002',
            'role'        => 'warga',
            'is_verified' => false,
            'password'    => Hash::make('password'),
        ]);

        // Sample Letter Requests
        LetterRequest::create([
            'user_id'     => $warga1->id,
            'letter_type' => 'Pengantar KTP',
            'purpose'     => 'Pembuatan KTP baru karena hilang',
            'status'      => 'approved',
        ]);

        LetterRequest::create([
            'user_id'     => $warga2->id,
            'letter_type' => 'Pengantar SKCK',
            'purpose'     => 'Keperluan melamar pekerjaan',
            'status'      => 'pending',
        ]);

        LetterRequest::create([
            'user_id'     => $warga1->id,
            'letter_type' => 'Surat Keterangan Domisili',
            'purpose'     => 'Keperluan administrasi kantor',
            'status'      => 'pending',
        ]);

        // Sample Complaints
        Complaint::create([
            'user_id'     => $warga1->id,
            'title'       => 'Lampu Jalan Padam',
            'description' => 'Lampu jalan di depan gang RT 005 sudah padam selama 3 hari. Mohon segera diperbaiki karena sangat gelap di malam hari.',
            'status'      => 'process',
        ]);

        Complaint::create([
            'user_id'     => $warga2->id,
            'title'       => 'Sampah Menumpuk',
            'description' => 'Tumpukan sampah di sudut Jl. Kenanga sudah menumpuk lebih dari seminggu dan menimbulkan bau tidak sedap.',
            'status'      => 'pending',
        ]);

        Complaint::create([
            'user_id'     => $warga3->id,
            'title'       => 'Jalan Berlubang',
            'description' => 'Jalan di depan rumah No. 20 berlubang cukup besar dan membahayakan pengendara motor.',
            'status'      => 'resolved',
        ]);

        // Sample Dues
        $months = ['2026-06', '2026-07', '2026-08'];
        $verifiedWarga = [$warga1, $warga2, $warga3];

        foreach ($verifiedWarga as $warga) {
            foreach ($months as $index => $month) {
                Due::create([
                    'user_id'      => $warga->id,
                    'month_year'   => $month,
                    'amount'       => 50000,
                    'status'       => $index < 2 ? 'paid' : 'unpaid', // June & July paid, August unpaid
                    'payment_date' => $index < 2 ? '2026-' . str_pad($index + 6, 2, '0', STR_PAD_LEFT) . '-10' : null,
                ]);
            }
        }
    }
}
