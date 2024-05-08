<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;
use App\Http\Controllers\lokasiController;
use App\Http\Controllers\pengunjungController;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\UndanganPengunjungController;

//pengunjung
Route::get('/registrasi', [RegisterController::class, 'showFormRegister'])->name('registrasi.showFormRegister');
Route::post('/registrasi', [RegisterController::class, 'store'])->name('registrasi.store');

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.showLoginForm');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/forgot-password', function () {})->name('forgot.password');

Route::get('/beranda', [UndanganPengunjungController::class, 'indeX_beranda'])->name('beranda.show')->middleware('isLogin');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/coba', [RegisterController::class, 'coba']);
Route::get('/app', [RegisterController::class, 'app']);

Route::view('/kunjungan', 'kunjungan',[ "title" => "Kunjungan"])->name('kunjungan');
Route::get('/host', [pengunjungController::class, 'index_host'])->name('host.show');
Route::get('/janji_temu', [UndanganPengunjungController::class, 'index_janji_temu'])->name('janji_temu.show');
Route::post('/janji-temu', [UndanganPengunjungController::class, 'store'])->name('janji_temu.store');

Route::get('/undangan/{id}', [UndanganPengunjungController::class, 'detail_undangan'])->name('detail_undangan.show');

Route::view('/lokasi', 'lokasi',[ "title" => "Lokasi"])->name('lokasi');
Route::view('/profile', 'profile',[ "title" => "Profile"])->name('profile');
Route::view('/riwayat', 'riwayat',[ "title" => "Riwayat"])->name('riwayat');


Route::get('/profile/edit', [pengunjungController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update',[pengunjungController::class, 'update'])->name('profile.update');

// Host
Route::get('/beranda_host', [HostController::class, 'index_host'])->name('berandahost.show');

Route::post('/beranda_host_index_accept', [HostController::class, 'index_accept'])->name('accept.show');
Route::post('/beranda_host/accept/{undangan_id}', [HostController::class, 'acceptUndangan'])->name('accept.undangan');
Route::post('/beranda_host/reject', [HostController::class, 'rejectUndangan'])->name('reject.undangan');

//admin
Route::view('/berandaadmin', 'admin/berandaadmin',[ "title" => "Beranda"])->name('berandaadmin.show');
Route::get('/hostadmin', [adminController::class, 'index'])->name('hostadmin.show');
Route::view('/Ladmin', 'admin/loginadmin',)->name('loginadmin.show');
Route::post('/tambah-host', [adminController::class, 'store'])->name('Tambah_host.store');
Route::get('/tampilkan_host', [adminController::class, 'index'])->name('tampilkan_host');

Route::get('/detail/{id}', [adminController::class, 'detail'])->name('host.detail');
Route::put('/update/{id}', [adminController::class, 'update'])->name('host.update');
Route::delete('/host/{host}', [adminController::class, 'destroy'])->name('hostadmin.destroy');

Route::post('/tambah_lokasi', [lokasiController::class, 'store'])->name('lokasi.store');


Route::get('/tambahhost', [adminController::class, 'index_tambah_host'])->name('tambahhost.show');

Route::get('/divisi', [DivisiController::class, 'index_divisi'])->name('divisi.show');
Route::post('/divisi/store', [DivisiController::class, 'store'])->name('divisi.store');
Route::put('/divisi/{id}', [DivisiController::class, 'update'])->name('divisi.update');
Route::delete('/divisi/{id}', [DivisiController::class, 'destroy'])->name('divisi.destroy');

Route::get('/lokasi_admin', [lokasiController::class, 'index_lokasi'])->name('lokasi.show');
Route::get('/tambah_lokasi', [lokasiController::class, 'index_tambah_lokasi'])->name('tambah_lokasi.show');






//entry_point
Route::view('/berandaentrypoint', 'entry_point/berandaentrypoint',[ "title" => "Beranda"])->name('berandaentrypoint.show');





