@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-4">
    <div class="col-md-4">
        <div class="card text-center mb-3" style="height: 320px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px;" id="">
                    {{ $undangan_masuk }}
                </div>
                <div class="mt-4">
                    <i class="fa-solid fa-user cardb-icon" style="font-size: 30px;"></i>
                </div>
                <p class="card-text mt-3" style="font-size: 15px;"><span style="font-weight: bold;">Menunggu Konfirmasi</span></p>
                <button class="btn btn-primary mt-2 filter-button" data-bs-toggle="modal" data-bs-target="#undanganModalMenunggu">Tampilkan</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center mb-3" style="height: 320px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px;" id="">
                    {{ $undangan_akan_datang }}
                </div>
                <div class="mt-4">
                    <i class="fa-solid fa-user-group cardb-icon" style="font-size: 30px;"></i>
                </div>
                <p class="card-text mt-3" style="font-size: 15px;"><span style="font-weight: bold;">Sudah Disetujui</span></p>
                <button class="btn btn-primary mt-2 filter-button" data-bs-toggle="modal" data-bs-target="#undanganModalDatang">Tampilkan</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center mb-3" style="height: 320px; background-color: white; border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 80px;" id="">
                    {{ $undangan_kadaluarsa }}
                </div>
                <div class="mt-4">
                    <i class="fa-solid fa-user-slash cardb-icon" style="font-size: 30px;"></i>
                </div>
                <p class="card-text mt-3" style="font-size: 15px;"><span style="font-weight: bold;">Kadaluarsa</span></p>
                <button class="btn btn-primary mt-2 filter-button" data-bs-toggle="modal" data-bs-target="#undanganModalKadaluarsa" >Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Menunggu Konfirmasi -->
<div class="modal fade" id="undanganModalMenunggu" tabindex="-1" aria-labelledby="undanganModalMenungguLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="undanganModalMenungguLabel">Undangan Menunggu Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="text-dark">
                            <th>Nama Host</th>
                            <th>Subjek</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBodyMenunggu">
                        @foreach($pengunjung as $undangan)
                            @if($undangan->status == 'Menunggu')
                                <tr>
                                    <td>{{ $undangan->host->nama }}</td>
                                    <td>{{ $undangan->subject }}</td>
                                    <td>{{ \Carbon\Carbon::parse($undangan->waktu_temu)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock"></i>
                                            {{ $undangan->status }}
                                        </span>                                                                               
                                    </td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#undanganDetailModal{{ $undangan->id }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>                
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Yang Akan Datang -->
<div class="modal fade" id="undanganModalDatang" tabindex="-1" aria-labelledby="undanganModalDatangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="undanganModalDatangLabel">Detail Undangan Yang Akan Datang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p" >
                            <th><strong>Nama Host</strong></th>
                            <th><strong>Subjek</strong></th>
                            <th><strong>Waktu</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Detail</strong></th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBodyDatang">
                        @foreach($pengunjung as $undangan)
                            @if($undangan->status == 'Diterima')
                                <tr>
                                    <td>{{ $undangan->host->nama }}</td>
                                    <td>{{ $undangan->subject }}</td>
                                    <td>{{ $undangan->waktu_temu }}</td>
                                    <td>
                                        <span class="badge light badge-success">
                                            <i class="fa fa-circle text-success me-1"></i>
                                            {{ $undangan->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#undanganDetailModal{{ $undangan->id }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kadaluarsa -->
<div class="modal fade" id="undanganModalKadaluarsa" tabindex="-1" aria-labelledby="undanganModalKadaluarsaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="undanganModalKadaluarsaLabel">Detail Undangan Kadaluarsa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>Nama Host</strong></th>
                            <th><strong>Subjek</strong></th>
                            <th><strong>Waktu</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Detail</strong></th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBodyKadaluarsa">
                        @foreach($pengunjung as $undangan)
                            @if($undangan->status == 'Kadaluarsa')
                                <tr>
                                    <td>{{ $undangan->host->nama }}</td>
                                    <td>{{ $undangan->subject }}</td>
                                    <td>{{ $undangan->waktu_temu }}</td>
                                    <td>
                                        <span class="badge light badge-secondary">
                                            <i class="fa fa-circle text-secondary me-1"></i>
                                            {{ $undangan->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#undanganDetailModal{{ $undangan->id }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($pengunjung as $item)
<!-- Modal Detail -->
<div class="modal fade" id="undanganDetailModal{{ $item->id }}" tabindex="-1" aria-labelledby="undanganDetailModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="undanganDetailModalLabel{{ $item->id }}">Riwayat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-5">Nama Lengkap</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->pengunjung->namaLengkap }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Host</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->host->nama }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Divisi</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->host->divisi->nama_divisi }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Kunjungan dari</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->kunjungan_dari }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Waktu Temu</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ \Carbon\Carbon::parse($item->waktu_temu)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Waktu Kembali</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ \Carbon\Carbon::parse($undangan->waktu_kembali)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Keperluan</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->subject }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Ruangan</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->lokasi->ruangan }} {{ $item->lokasi->lantai }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Nomor Telepon</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->pengunjung->nomor_telepon }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Email</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->pengunjung->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Status</div>
                        <div class="col-1">:</div>
                        <div class="col-6">
                            @if($item->status == 'Kadaluarsa')
                                <span class="badge light badge-secondary">
                                    <i class="fa fa-circle text-secondary me-1"></i>
                                    {{ $item->status }}
                                </span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge light badge-success">
                                    <i class="fa fa-circle text-success me-1"></i>
                                    {{ $item->status }}
                                </span> 
                            @elseif($item->status == 'Menunggu') 
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock"></i>
                                    {{ $item->status }}
                                </span> 
                            @elseif($item->status == 'Diterima')
                                <span class="badge light badge-success">
                                    <i class="fa fa-circle text-sucsess me-1"></i>
                                    {{ $item->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function() {
                let target = button.getAttribute('data-bs-target');
                document.querySelector(target).classList.add('show');
                document.querySelector(target).style.display = 'block';
            });
        });

        document.querySelectorAll('.btn-close').forEach(button => {
            button.addEventListener('click', function() {
                let modal = button.closest('.modal');
                modal.classList.remove('show');
                modal.style.display = 'none';
            });
        });
    });
</script>

{{-- <script>
    var response = true;

function request(){
    if(response == true){
        response = false;
        var req = $.ajax({
            type: "GET",
            url: "/check-and-update-status",
            dataType: 'json' // Ensure the response is JSON
        });

        req.done(function(data){
            console.log("Request successful!", data);
            $('#undanganMasukCount').text(data.undangan_masuk);
            $('#undanganDatangCount').text(data.undangan_akan_datang);
            $('#undanganKadaluarsaCount').text(data.undangan_kadaluarsa);
            response = true;
        });

        req.fail(function(jqXHR, textStatus, errorThrown){
            console.error("Request failed: ", textStatus, errorThrown);
            response = true;
        });
    }

    setTimeout(request, 1000); // Polling interval set to 1 second
}

$(document).ready(function() {
    request();
});

</script> --}}

@endsection
