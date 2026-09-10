# Dokumentasi Proyek: SIRA (Sistem Informasi Rukun Warga)

Proyek ini adalah sebuah sistem informasi berbasis web yang dibangun menggunakan framework **Laravel 11**. Aplikasi ini ditujukan untuk mempermudah administrasi dan interaksi di tingkat Rukun Warga (RW) atau Rukun Tetangga (RT), mencakup pengelolaan data warga, permohonan surat pengantar, layanan pengaduan, hingga pencatatan iuran.

## 🛠 Teknologi yang Digunakan
- **Framework Utama**: Laravel (v11.31)
- **Bahasa Pemrograman**: PHP (Minimal v8.2)
- **Package Tambahan**: 
  - `barryvdh/laravel-dompdf` (Untuk kebutuhan cetak atau ekspor surat/laporan dalam format PDF)
- **Frontend Assets**: Vite & Tailwind CSS (Berdasarkan keberadaan `vite.config.js` dan `tailwind.config.js`)

## 👥 Aktor / Role Sistem
Sistem ini menggunakan *Role-Based Access Control* dengan middleware khusus (`role:admin` dan `role:warga`), serta pengecekan akun yang sudah diverifikasi (`verified.account`). Terdapat 3 tingkatan akses:
1. **Guest (Tamu)**: Pengguna yang belum login.
2. **Admin**: Pengurus RW/RT yang memiliki akses penuh untuk mengelola data operasional.
3. **Warga**: Penduduk terdaftar yang sudah diverifikasi, bertindak sebagai pengguna layanan.

---

## 📋 Daftar Fitur (Berdasarkan Role)

### 1. Fitur Guest (Tamu)
- **Halaman Landing**: Halaman utama informasi (Landing Page).
- **Login & Register**: Proses autentikasi dan pendaftaran akun baru bagi warga.

### 2. Fitur Admin
Hak akses khusus untuk pengurus. Admin memiliki wewenang untuk menyetujui, mengelola, dan mengekspor berbagai data.
- **Dashboard Admin**: Ringkasan data operasional RW/RT.
- **Manajemen Warga** (`/admin/warga`): 
  - Melihat daftar dan detail warga.
  - Memverifikasi / Menyetujui akun warga yang baru mendaftar (Verification).
  - Mengekspor data warga.
- **Manajemen Surat Pengantar** (`/admin/surat`):
  - Melihat daftar permohonan surat pengantar dari warga.
  - Menerima (Approve) atau Menolak (Reject) permohonan surat.
  - **Mencetak Surat (PDF)** untuk surat yang disetujui.
- **Manajemen Pengaduan** (`/admin/pengaduan`):
  - Melihat daftar keluhan / pengaduan warga.
  - Memperbarui status pengaduan (misal: "Diproses", "Selesai").
  - Mengekspor data pengaduan.
- **Manajemen Iuran** (`/admin/iuran`):
  - Membuat tagihan iuran baru.
  - Menandai iuran sebagai "Lunas" (Paid) atau "Belum Lunas" (Unpaid).
  - Mengekspor data laporan iuran.

### 3. Fitur Warga
Akses untuk warga yang akunnya sudah disetujui (verified) oleh admin.
- **Dashboard Warga**: Ringkasan status layanan (surat, pengaduan, iuran).
- **Layanan Surat Pengantar** (`/warga/surat`):
  - Mengajukan permohonan surat pengantar baru.
  - Memantau status (Riwayat) permohonan surat yang diajukan.
- **Layanan Pengaduan** (`/warga/pengaduan`):
  - Membuat laporan pengaduan baru terkait lingkungan atau masalah lainnya.
  - Melihat status dan riwayat pengaduan yang pernah dibuat.
- **Informasi Iuran** (`/warga/iuran`):
  - Melihat daftar tagihan iuran bulanan atau khusus beserta status pembayarannya.

---

## 🗄 Struktur Database (Model Inti)
Aplikasi ini memiliki 4 model utama yang merepresentasikan entitas bisnis dalam sistem:
1. `User.php`: Menyimpan data autentikasi dan profil warga maupun admin (termasuk validasi dan peran).
2. `LetterRequest.php`: Menyimpan data pengajuan surat pengantar (Siapa yang mengajukan, keperluan, dan statusnya).
3. `Complaint.php`: Menyimpan data pengaduan warga beserta status penyelesaiannya.
4. `Due.php`: Menyimpan data tagihan dan catatan pembayaran iuran warga.
