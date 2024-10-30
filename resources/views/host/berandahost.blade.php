@extends('host.layouts.main')

@section('content')
<div class="row justify-content-center mb-4">
    <!-- Card untuk Undangan Masuk -->
    <div class="col-md-3">
        <div class="card text-center" style="height: 290px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px; color: #0D568B;">
                    {{ $undangan_masuk }}
                </div>
                <p class="card-text" style="font-size: 15px;"><i class="fa-regular fa-calendar"></i> <span style="font-weight: bold; color: #BDBDBD;">Hari Ini</span></p>
                <div class="">
                    <i class="fa-solid fa-user cardb-icon" style="font-size: 20px;"></i>
                </div>
                <p class="card-text" style="font-size: 15px; "><span style="font-weight: bold;">Undangan Masuk</span></p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#undanganMasukModal">Selengkapnya</button>
            </div>
        </div>
    </div>

    <!-- Card untuk Undangan Akan Datang -->
    <div class="col-md-3">
        <div class="card text-center" style="height: 290px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px; color: #0D568B;">
                    {{ $undangan_akan_datang }} 
                </div>
                <p class="card-text " style="font-size: 15px;"><i class="fa-regular fa-calendar"></i> <span style="font-weight: bold; color: #BDBDBD;">Hari Ini</span></p>
                <div class="">
                    <i class="fa-solid fa-user-group cardb-icon" style="font-size: 20px;"></i>
                </div>
                <p class="card-text" style="font-size: 15px; "><span style="font-weight: bold;">Sudah Disetujui</span></p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#undanganAkanDatangModal">Selengkapnya</button>
            </div>
        </div>
    </div>

    <!-- Card untuk Total Kunjungan Check In/Out -->
    <div class="col-md-3">
        <div class="card text-center" style="height: 290px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px; color: #0D568B;">
                   {{ $total_kunjungan_check_in_out  }}
                </div>
                <p class="card-text" style="font-size: 15px;"><i class="fa-regular fa-calendar"></i> <span style="font-weight: bold; color: #BDBDBD;">Hari Ini</span></p>
                <div class="">
                   <i class="fa-solid fa-user-check cardb-icon" style="font-size: 20px;"></i>
                </div>
                <p class="card-text" style="font-size: 15px; "><span style="font-weight: bold;">Check In/Out</span></p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kunjunganCheckInOutModal">Selengkapnya</button>
            </div>
        </div>
    </div> 

    <!-- Card untuk Undangan yang Sudah Kadaluarsa -->
    <div class="col-md-3">
        <div class="card text-center" style="height: 290px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px; color: #0D568B;">
                    {{ $undangan_kadaluarsa }} 
                </div>
                <p class="card-text" style="font-size: 15px;"><i class="fa-regular fa-calendar"></i> <span style="font-weight: bold; color: #BDBDBD;">Hari Ini</span></p>
                <div class="">
                    <i class="fa-solid fa-user-slash cardb-icon" style="font-size: 20px;"></i>
                </div>
                <p class="card-text" style="font-size: 15px; "><span style="font-weight: bold;">Kadaluarsa</span></p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#undanganKadaluarsaModal">Selengkapnya</button>
            </div>
        </div>
    </div>

</div>

<!-- Modal untuk Undangan Masuk -->
<div class="modal fade" id="undanganMasukModal" tabindex="-1" aria-labelledby="undanganMasukModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Tambahkan kelas modal-lg untuk menyesuaikan lebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Undangan Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Subjek</th>
                            <th>Waktu Temu</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($undangan_masukdata as $undangan)
                                <tr>
                                    <td>{{ $undangan->pengunjung->namaLengkap }}</td>
                                    <td>{{ $undangan->subject }}</td>
                                    <td>{{ $undangan->waktu_temu }}</td>
                                    <td>{{ $undangan->waktu_kembali }}</td>
                                    <td>{{ $undangan->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Undangan Akan Datang -->
<div class="modal fade" id="undanganAkanDatangModal" tabindex="-1" aria-labelledby="undanganAkanDatangModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Tambahkan kelas modal-lg untuk menyesuaikan lebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sudah Disetujui</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Host</th>
                            <th>Waktu Temu</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($undangan_akan_datangdata as $undangan)
                                <tr>
                                    <td>{{ $undangan->pengunjung->namaLengkap }}</td>
                                    <td>{{ $undangan->subject }}</td>
                                    <td>{{ $undangan->waktu_temu }}</td>
                                    <td>{{ $undangan->waktu_kembali }}</td>
                                    <td>{{ $undangan->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Total Kunjungan Check In/Out -->
<div class="modal fade" id="kunjunganCheckInOutModal" tabindex="-1" aria-labelledby="kunjunganCheckInOutModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Tambahkan kelas modal-lg untuk menyesuaikan lebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Check In/Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Check_in</th>
                            <th>Check_out</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($combinedDatacheck as $data)
        <tr>
            <td>{{ $data['name'] }}</td>
            <td>{{ $data['check_in'] }}</td>
            <td>{{ $data['check_out'] }}</td>
        </tr>
    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Undangan yang Sudah Kadaluarsa -->
<div class="modal fade" id="undanganKadaluarsaModal" tabindex="-1" aria-labelledby="undanganKadaluarsaModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Tambahkan kelas modal-lg untuk menyesuaikan lebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kunjungan Kadaluarsa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Host</th>
                            <th>Waktu Temu</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($undangan_kadaluarsadata as $undangan)
                                <tr>
                                    <td>{{ $undangan->pengunjung->namaLengkap }}</td>
                                    <td>{{ $undangan->subject }}</td>
                                    <td>{{ $undangan->waktu_temu }}</td>
                                    <td>{{ $undangan->waktu_kembali }}</td>
                                    <td>{{ $undangan->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="col-lg-12">
    <div class="card custom-card">
        <div class="card-header">
            <h4 class="card-title">Kunjungan Hari Ini</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <li class="nav-item col-md-3">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="Search here...">
                        <span class="input-group-text">
                            <a href="javascript:void(0)">
                                <i class="flaticon-381-search-2"></i>
                            </a>
                        </span>
                    </div>
                </li>
                <br>
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>NO.</strong></th>
                            <th><strong>Pengunjung</strong></th>
                            <th><strong>check_in</strong></th>
                            <th><strong>check_out</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->
@endsection
