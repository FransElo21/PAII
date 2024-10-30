<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\EntryPointController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hostController;
use App\Http\Controllers\lokasiController;
use App\Http\Controllers\pengunjungController;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\UndanganPengunjungController;
use App\Models\UndanganPengunjung;


Route::group(['middleware' => 'isLogin'], function () {
    //pengunjung
    Route::get('/beranda', [pengunjungController::class, 'index_beranda'])->name('beranda.show');
    Route::get('/pantau_kunjungan', [pengunjungController::class, 'index_pantau'])->name('pantau_kunjungan.show');
    Route::get('/janji_temu', [UndanganPengunjungController::class, 'index_janji_temu'])->name('janji_temu.show');
    Route::post('/janji-temu', [UndanganPengunjungController::class, 'store'])->name('janji_temu.store');

    Route::get('/riwayat_pengunjung', [pengunjungController::class, 'index_riwayat_pengunjung'])->name('index_riwayat_pengunjung.show');

    Route::get('/coba', [RegisterController::class, 'coba']);
    Route::get('/app', [RegisterController::class, 'app']);
    Route::get('/buat_undangan', [UndanganPengunjungController::class, 'index_undangan'])->name('undangan.show');
    Route::get('/undangan/{id}', [UndanganPengunjungController::class, 'detail_undangan'])->name('detail_undangan.show');
    Route::view('/informasi_kunjungan', 'informasi_kunjungan',[ "title" => "Lokasi"])->name('lokasi');
    Route::get('/card', [pengunjungController::class, 'index_card_pengunjung'])->name('index_card_pengunjung.show');

    Route::get('/profile', [pengunjungController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [pengunjungController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/updateuser',[pengunjungController::class, 'update'])->name('profile.update');
});
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.showLoginForm');
    Route::get('/registrasi', [RegisterController::class, 'showFormRegister'])->name('registrasi.showFormRegister');
    Route::post('/registrasi', [RegisterController::class, 'store'])->name('registrasi.store');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/forgot-password', function () {})->name('forgot.password');
    

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'host'], function () {
    // Host
    Route::get('/beranda_host', [hostController::class, 'index_host'])->name('berandahost.show');

    Route::post('/beranda_host_index_accept', [hostController::class, 'index_accept'])->name('accept.show');
    Route::post('/beranda_host/accept/{undangan_id}', [hostController::class, 'acceptUndangan'])->name('accept.undangan');
    Route::post('/beranda_host/reject/{undangan_id}', [hostController::class, 'rejectUndangan'])->name('reject.undangan');

    Route::get('/buatkunjungan_host', [hostController::class, 'index_buatkunjungan_host'])->name('buatkunjungan_host.show');
    Route::get('/konfirmasi_kunjungan', [hostController::class, 'index_konfirmasi_kunjungan'])->name('konfirmasi_kunjungan.show');

    Route::get('/riwayat_host', [hostController::class, 'index_riwayat_host'])->name('riwayat_host.show');
    Route::get('/undangan/{id}', [hostController::class, 'show'])->name('detail_host.undangan');

    Route::get('/alasan_penolakan/{id}', [hostController::class, 'index_penolakan'])->name('index_penolakan.show');

    Route::post('store_undangan_host', [hostController::class, 'store_undangan_host'])->name('undangan_host.store');

    Route::get('/profile/edit1', [hostController::class, 'edit_host'])->name('profile_host.edit');
    Route::post('/profile/update',[hostController::class, 'update_host'])->name('profile_host.update');

    Route::view('/host_profile', 'host/profile_host',[ "title" => "Profile"])->name('profile_host');

});


Route::group(['middleware' => 'admin'], function () {
    //admin
    Route::view('/berandaadmin', 'admin/berandaadmin',[ "title" => "Beranda"])->name('berandaadmin.show');
    Route::get('/hostadmin', [adminController::class, 'index'])->name('hostadmin.show');
    Route::view('/Ladmin', 'admin/loginadmin',)->name('loginadmin.show');
    Route::post('/tambah-host', [adminController::class, 'store'])->name('Tambah_host.store');
    Route::get('/tampilkan_host', [adminController::class, 'index'])->name('tampilkan_host');

    Route::get('/detail/{id}', [adminController::class, 'detail'])->name('host.detail');
    Route::put('/update/{id}', [adminController::class, 'update'])->name('host.update');
    Route::put('/host/{id}', [adminController::class, 'update_host'])->name('host.update');
    Route::delete('/host/{host}', [adminController::class, 'destroy'])->name('hostadmin.destroy');

    Route::post('/tambah_lokasi', [lokasiController::class, 'store'])->name('lokasi.store');


    Route::get('/tambahhost', [adminController::class, 'index_tambah_host'])->name('tambahhost.show');

    Route::get('/divisi', [DivisiController::class, 'index_divisi'])->name('divisi.show');
    Route::post('/divisi/store', [DivisiController::class, 'store'])->name('divisi.store');
    Route::put('/divisi/{id}', [DivisiController::class, 'update'])->name('divisi.update');
    Route::delete('/divisi/{id}', [DivisiController::class, 'destroy'])->name('divisi.destroy');

    Route::get('/lokasi_admin', [lokasiController::class, 'index_lokasi'])->name('lokasi.show');
    Route::get('/tambah_lokasi', [lokasiController::class, 'index_tambah_lokasi'])->name('tambah_lokasi.show');
    Route::delete('/lokasi/{id}', [lokasiController::class, 'destroy'])->name('lokasi.destroy');

    Route::get('/riwayat_admin', [adminController::class, 'index_riwayat'])->name('riwayat.show');

    Route::get('/informasi_tamu', [adminController::class, 'index_informasitamu'])->name('informasitamu.show');

    Route::get('/edit_host/{id}', [AdminController::class, 'edit_host'])->name('edit_host.show');
    Route::post('/update_host/{id}', [AdminController::class, 'update_host'])->name('update_host');

    Route::get('/lokasi/{id}/edit', [LokasiController::class, 'index_edit'])->name('index_edit.show');
    Route::put('/lokasi/{id}', [LokasiController::class, 'update'])->name('update_lokasi');

    

    Route::get('profile_admin', [AdminController::class, 'index_profile_admin'])->name('profile_admin.show');

    Route::get('/admin/edit-password', [AdminController::class, 'editPasswordForm'])->name('admin.edit_password_form');
    Route::post('/admin/update-password', [AdminController::class, 'updatePassword'])->name('admin.update_password');
});


Route::group(['middleware' => 'entry_point.auth'], function () {   
    //entry_point
    Route::get('/berandaentry_point', [EntryPointController::class, 'index_entrypoint'])->name('berandaentrypoint.show');
    Route::get('/riwayatentry_point', [EntryPointController::class, 'index_riwayat'])->name('index_riwayat.show');
    Route::get('/informasitamuEP', [EntryPointController::class, 'index_IT'])->name('index_IT.show');

    Route::get('profile_Entrypoint', [EntryPointController::class, 'index_profile_entry'])->name('profile_entry.show');
    Route::get('/Entrypoint/edit-password', [EntryPointController::class, 'editPasswordForm'])->name('Entrypoint.edit_password_form');
    Route::post('/Entrypoint/update-password', [EntryPointController::class, 'updatePassword'])->name('Entrypoint.update_password');

    Route::post('/scan_qr_code', [EntryPointController::class, 'scanQrCode']);
    Route::get('/scan_qr_code2', [EntryPointController::class, 'index_scanQrCode'])->name('scanQrCode.show');

    Route::post('/check_qr_status', [EntryPointController::class, 'checkQrStatus']);


});

Route::get('/check-and-update-status', [UndanganPengunjungController::class, 'checkAndUpdateStatus']);
Route::post('/filter-riwayat', [UndanganPengunjungController::class, 'filterRiwayat'])->name('filter.riwayat');

Route::get('riwayat/cetak1', [AdminController::class, 'cetak1'])->name('riwayat.cetak1');
Route::get('riwayat/cetak2', [AdminController::class, 'cetak2'])->name('riwayat.cetak2');    

Route::get('cetak', [AdminController::class, 'index_cetak'])->name('index_cetak');
Route::get('cetak2', [AdminController::class, 'index_cetak2'])->name('index_cetak2');

Route::post('/update-undangan-status', [UndanganPengunjungController::class, 'updateUndanganStatus']);









 



