<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DueController as AdminDueController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\LetterRequestController;
use App\Http\Controllers\Warga\ComplaintController as WargaComplaintController;
use App\Http\Controllers\Warga\DueController as WargaDueController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Guest Routes (Login & Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'verified.account', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Warga Management
        Route::resource('warga', WargaController::class)->except(['show']);
        Route::patch('/warga/{warga}/verify', [WargaController::class, 'verify'])->name('warga.verify');

        // Surat Pengantar Management
        Route::get('/surat', [LetterController::class, 'index'])->name('surat.index');
        Route::get('/surat/{letter}', [LetterController::class, 'show'])->name('surat.show');
        Route::patch('/surat/{letter}/approve', [LetterController::class, 'approve'])->name('surat.approve');
        Route::patch('/surat/{letter}/reject', [LetterController::class, 'reject'])->name('surat.reject');
        Route::get('/surat/{letter}/pdf', [LetterController::class, 'printPdf'])->name('surat.pdf');

        // Pengaduan Management
        Route::get('/pengaduan', [AdminComplaintController::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/{complaint}', [AdminComplaintController::class, 'show'])->name('pengaduan.show');
        Route::patch('/pengaduan/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('pengaduan.status');

        // Iuran Management
        Route::get('/iuran', [AdminDueController::class, 'index'])->name('iuran.index');
        Route::get('/iuran/create', [AdminDueController::class, 'create'])->name('iuran.create');
        Route::post('/iuran', [AdminDueController::class, 'store'])->name('iuran.store');
        Route::patch('/iuran/{due}/paid', [AdminDueController::class, 'markPaid'])->name('iuran.paid');
        Route::patch('/iuran/{due}/unpaid', [AdminDueController::class, 'markUnpaid'])->name('iuran.unpaid');
    });

/*
|--------------------------------------------------------------------------
| Warga Routes
|--------------------------------------------------------------------------
*/
Route::prefix('warga')
    ->middleware(['auth', 'verified.account', 'role:warga'])
    ->name('warga.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');

        // Surat Pengantar
        Route::get('/surat', [LetterRequestController::class, 'index'])->name('surat.index');
        Route::get('/surat/create', [LetterRequestController::class, 'create'])->name('surat.create');
        Route::post('/surat', [LetterRequestController::class, 'store'])->name('surat.store');

        // Pengaduan
        Route::get('/pengaduan', [WargaComplaintController::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/create', [WargaComplaintController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [WargaComplaintController::class, 'store'])->name('pengaduan.store');

        // Iuran
        Route::get('/iuran', [WargaDueController::class, 'index'])->name('iuran.index');
    });
