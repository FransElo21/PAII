<?php

use App\Http\Controllers\DivisiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryPointController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/datepicker', function (Request $request) {
    // Mendapatkan data tanggal dari permintaan (jika ada)
    $date = $request->input('date');

    // Lakukan operasi yang diperlukan, misalnya mendapatkan data berdasarkan tanggal
    // Contoh: $data = YourModel::whereDate('created_at', $date)->get();
    // Tapi untuk sekarang, kita hanya mengembalikan tanggal

    // Return data dalam format JSON
    return response()->json(['date' => $date]);
});

// Route::post('/scan_qr_code', [EntryPointController::class, 'scanQrCode']);

// Route::get('tes', function(){
//     return 'hai';
// });

Route::get('/api/get-divisions', [DivisiController::class, 'getDivisions']);
Route::get('/api/filter-data-by-division', [DivisiController::class, 'filterDataByDivision']);