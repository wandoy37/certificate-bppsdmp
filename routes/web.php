<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PenandatanganController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Training;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/laravel-info', function () {
    return view('welcome');
});

Route::controller(HomeController::class)->group(function () {
    // Category
    Route::get('/', 'index')->name('home.index');
    Route::get('/category/{slug}', 'show_category')->name('show.category');

    // Trainings / Pelatihan
    Route::get('/training/{slug}', 'show_training')->name('show.training');
    Route::get('/participant/{slug}', 'show_participant')->name('show.participant');

    // Certificate Single
    Route::get('/certificate/{code}', [HomeController::class, 'show_certificate'])->name('show.certificate');
});

// Auth
Route::prefix('auth')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // User Controller
    Route::get('/pengguna', [UserController::class, 'index'])->name('dashboard.user.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('dashboard.user.create');
    Route::post('/pengguna/store', [UserController::class, 'store'])->name('dashboard.user.store');
    Route::get('/pengguna/{slug}/edit', [UserController::class, 'edit'])->name('dashboard.user.edit');
    Route::patch('/pengguna/{slug}/update', [UserController::class, 'update'])->name('dashboard.user.update');
    Route::delete('/pengguna/{slug}/delete', [UserController::class, 'destroy'])->name('dashboard.user.delete');

    // Route Kelola Sertifikat

    // Category
    Route::get('/category', [CategoryController::class, 'index'])->name('dashboard.category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('dashboard.category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('dashboard.category.store');
    Route::get('/category/{slug}/edit', [CategoryController::class, 'edit'])->name('dashboard.category.edit');
    Route::patch('/category/{slug}/update', [CategoryController::class, 'update'])->name('dashboard.category.update');
    Route::delete('/category{slug}/delete', [CategoryController::class, 'destroy'])->name('dashboard.category.delete');

    // Training / Pelatihan
    Route::get('/pelatihan', [TrainingController::class, 'index'])->name('dashboard.training.index');
    Route::get('/pelatihan/create', [TrainingController::class, 'create'])->name('dashboard.training.create');
    Route::post('/pelatihan/store', [TrainingController::class, 'store'])->name('dashboard.training.store');
    Route::get('/pelatihan/{slug}/edit', [TrainingController::class, 'edit'])->name('dashboard.training.edit');
    Route::patch('/pelatihan/{slug}/update', [TrainingController::class, 'update'])->name('dashboard.training.update');
    Route::delete('/pelatihan/{slug}/delete', [TrainingController::class, 'destroy'])->name('dashboard.training.delete');

    // Participants / Peserta
    Route::get('/peserta', [ParticipantController::class, 'index'])->name('dashboard.participant.index');
    Route::get('/peserta/create', [ParticipantController::class, 'create'])->name('dashboard.participant.create');
    Route::post('/peserta/store', [ParticipantController::class, 'store'])->name('dashboard.participant.store');
    Route::get('/peserta/{slug}/edit', [ParticipantController::class, 'edit'])->name('dashboard.participant.edit');
    Route::patch('/peserta/{slug}/update', [ParticipantController::class, 'update'])->name('dashboard.participant.update');
    Route::delete('/peserta/{slug}/delete', [ParticipantController::class, 'destroy'])->name('dashboard.participant.delete');

    // Generate Certificate
    Route::get('/peserta/{slug}/show', [ParticipantController::class, 'show'])->name('dashboard.participant.show');

    // Certificates / Sertifikasi
    Route::get('/sertifikat', [CertificateController::class, 'index'])->name('dashboard.certificate.index');
    Route::get('/sertifikat/create', [CertificateController::class, 'create'])->name('dashboard.certificate.create');
    Route::post('/sertifikat/store', [CertificateController::class, 'store'])->name('dashboard.certificate.store');
    Route::get('/sertifikat/{code}/edit', [CertificateController::class, 'edit'])->name('dashboard.certificate.edit');
    Route::patch('/sertifikat/{code}/update', [CertificateController::class, 'update'])->name('dashboard.certificate.update');
    Route::delete('/sertifikat/{code}/delete', [CertificateController::class, 'destroy'])->name('dashboard.certificate.delete');


    // Cetak
    Route::get('/cetak/pelatihan/{code}', [CertificateController::class, 'cetakPelatihan'])->name('dashboard.certificate.cetak.pelatihan');
    Route::get('/cetak/bimtek/{code}', [CertificateController::class, 'cetakBimtek'])->name('dashboard.certificate.cetak.bimtek');

    // Penandatangan
    Route::get('/penandatangan', [PenandatanganController::class, 'index'])->name('dashboard.penandatangan.index');
    Route::get('/penandatangan/create', [PenandatanganController::class, 'create'])->name('dashboard.penandatangan.create');
    Route::post('/penandatangan/store', [PenandatanganController::class, 'store'])->name('dashboard.penandatangan.store');
    Route::get('/penandatangan/{slug}/edit', [PenandatanganController::class, 'edit'])->name('dashboard.penandatangan.edit');
    Route::patch('/penandatangan/{slug}/update', [PenandatanganController::class, 'update'])->name('dashboard.penandatangan.update');
    Route::delete('penandatangan/{slug}/delete', [PenandatanganController::class, 'destroy'])->name('dashboard.penandatangan.delete');
});
