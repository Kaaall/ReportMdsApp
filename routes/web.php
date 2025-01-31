<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TargetLeasingController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\BookingController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/data', [AuthController::class, 'login'])->name('login.data');
Route::get('/surat/{kode_dealer}', [SuratController::class, 'index'])->name('laporan.user.surat');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.data');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/incoming', [IncomingController::class, 'index'])->name('upload.incoming');
Route::post('/incoming/import', [IncomingController::class, 'import'])->name('incoming.import');

Route::get('/booking', [BookingController::class, 'index'])->name('upload.booking');
Route::post('/import/booking', [BookingController::class, 'import'])->name('import.booking');

Route::get('/target', [TargetLeasingController::class, 'index'])->name('index.target');
Route::post('/target/upload', [TargetLeasingController::class, 'upload'])->name('upload.target');
// routes/web.php
Route::post('export/excel', [SuratController::class, 'exportExcel'])->name('export.excel');

Route::get('surat', [SuratController::class, 'index'])->name('laporan.suratAsli');
Route::get('/laporan/surat', [SuratController::class, 'index'])->name('surat');
Route::post('/export-pdf', [SuratController::class, 'exportPdf'])->name('exportPdf');
Route::post('/surat.submit', [SuratController::class, 'submit'])->name('surat.submit');
