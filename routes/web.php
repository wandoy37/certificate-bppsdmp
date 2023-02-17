<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainingController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/sertifikat', function () {
    return view('sertifikat');
});

Route::controller(HomeController::class)->group(function () {
    // Category
    Route::get('/', 'index')->name('home.index');
    Route::get('/category/{slug}', 'show_category')->name('show.category');

    // Trainings / Pelatihan
    Route::get('/training/{slug}', 'show_training')->name('show.training');
    Route::get('/participant/{slug}', 'show_participant')->name('show.participant');
});

// Auth
Route::prefix('auth')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
});
