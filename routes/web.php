<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruPensiunController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PindahNaikKelasController;
use App\Http\Controllers\RiwayatPelanggaranController;
use App\Http\Controllers\RiwayatPrestasiController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::resource('/admin', AdminController::class)->middleware('auth');

Route::resource('/guru', GuruController::class)->middleware('auth');

Route::resource('/siswa', SiswaController::class)->middleware('auth');

Route::resource('/pelanggaran', PelanggaranController::class)->middleware('auth');

Route::resource('/sipelanggaran', RiwayatPelanggaranController::class)->middleware('auth');

Route::get('/riwayat-pelanggaran-siswa', [RiwayatPelanggaranController::class, 'riwayatSiswa'])->middleware('auth');
Route::get('/riwayat-pelanggaran', [RiwayatPelanggaranController::class, 'riwayatGuru'])->middleware('auth');
Route::get('/pelanggaran-siswa', [RiwayatPelanggaranController::class, 'pelanggaranSiswa'])->middleware('auth');
Route::get('/detail-pelanggaran-siswa/{nips}', [RiwayatPelanggaranController::class, 'show'])->middleware('auth');
Route::delete('/detail-pelanggaran-siswa/{nips}/{id}', [RiwayatPelanggaranController::class, 'hapusDetail'])->name('pelanggaran.destroy');

Route::resource('/prestasi', PrestasiController::class)->middleware('auth');
Route::delete('/prestasi/{id}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');


Route::resource('/siprestasi', RiwayatPrestasiController::class)->middleware('auth');

Route::get('/riwayat-prestasi-siswa', [RiwayatPrestasiController::class, 'riwayatSiswa'])->middleware('auth');
Route::get('/riwayat-prestasi', [RiwayatPrestasiController::class, 'riwayatGuru'])->middleware('auth');
Route::get('/prestasi-siswa', [RiwayatPrestasiController::class, 'prestasiSiswa'])->middleware('auth');
Route::get('/detail-prestasi-siswa/{nips}', [RiwayatPrestasiController::class, 'show'])->middleware('auth');
Route::delete('/detail-prestasi-siswa/{nips}/{id}', [RiwayatPrestasiController::class, 'hapusDetail'])->name('prestasi.destroy');

Route::resource('/siprestasi', RiwayatPrestasiController::class)->middleware('auth');
Route::resource('/kelas', KelasController::class)->middleware('auth');
Route::resource('/guru-pensiun', GuruPensiunController::class)->middleware('auth');
Route::resource('/alumni', AlumniController::class)->middleware('auth');
Route::resource('/pindah-naik-kelas', PindahNaikKelasController::class)->middleware('auth');
Route::put('/guru/{id}/status', [GuruController::class, 'updateStatus']);
Route::get('/siswa/by_kelas/{kelas}', [PindahNaikKelasController::class, 'getSiswaByKelas']);
Route::post('/pindah-naik/update', [PindahNaikKelasController::class, 'update'])->name('pindah-naik.update');
Route::get('/pindah-naik-kelas', [PindahNaikKelasController::class, 'index'])->name('pindah-naik.index');

Route::post('/change-password', [PasswordController::class, 'updatePassword'])->name('password.update');
Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');