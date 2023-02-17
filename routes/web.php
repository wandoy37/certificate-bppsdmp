<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
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
});
