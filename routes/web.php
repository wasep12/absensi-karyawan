<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SettingsController;

Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
Route::get('/', [PagesController::class, 'dashboard']);
// DATA KARYAWAN
Route::get('/karyawan', [KaryawanController::class, 'index']);
Route::get('/tambah-karyawan', [KaryawanController::class, 'create']);
Route::get('/edit-karyawan/{id}', [KaryawanController::class, 'edit']);
Route::post('/postkaryawan', [KaryawanController::class, 'store']);
Route::post('/editkaryawan', [KaryawanController::class, 'update']);
Route::get('/hapus-karyawan/{id}', [KaryawanController::class, 'destroy']);

// DATA ABSEN 
Route::get('/absensi', [PagesController::class, 'absensi']);

// PRESENSI
Route::get('/scan', [PagesController::class, 'scan_absen']);

// FUNGSI REALTIME
Route::get('/reader', [PagesController::class, 'reader']);
Route::get('/nokartu', [PagesController::class, 'nokartu']);


// FUNGSI GET LINK ARDUINO
Route::get('/postkartu/{id}', [PagesController::class, 'temp']);
Route::get('/mode', [PagesController::class, 'mode']);

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
// Jika Anda masih ingin menggunakan middleware auth di route lainnya, jangan hapus yang lain
Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
Route::post('/settings/mode', [SettingsController::class, 'mode'])->name('settings.mode');
Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

Route::get('/export-csv', [PagesController::class, 'exportCsv'])->name('export.csv');
Route::get('/export-pdf', [PagesController::class, 'exportPdf'])->name('export.pdf');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');