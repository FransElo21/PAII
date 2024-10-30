@extends('host.layouts.main')

@section('content')
<style>
    .custom-span {
        font-weight: 300;
        color: #333;
        font-size: 15px;
    }

    .custom-p {
        color: white;
        background-color: #c9121c;
    }
    .primary-table-bordered th {
        background-color: #c9121c; /* Warna latar belakang */
        color: #fff; /* Warna teks */
    }

    .card-shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Custom shadow effect */
    }

    .custom-tab-1 .nav-tabs .nav-link {
        font-size: 16px; /* Increase font size for tab links */
    }

    .card-title, .nav-tabs .nav-link, .tab-pane h4 {
        font-size: 24px; /* Larger font size for titles */
    }

    /* Tambahkan CSS untuk latar belakang merah dan teks hitam pada header tabel */
    .red-header th {
        background-color: #c9121c; /* Latar belakang merah */
        color: white; /* Teks hitam */
    }
</style>
<div class="col-xl-12">
    <div class="card card-shadow">
        <div class="card-header">
            <h2 class="card-title">Riwayat</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1">Kunjungan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile1">Undangan</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home1" role="tabpanel">
                        <div class="pt-4">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-6">
                                            <div class="input-group search-area" style="width: 200px;">
                                            <input type="text" id="searchInputKunjungan" class="form-control custom-search-input" placeholder="Search here...">
                                                <span class="input-group-text">
                                                    <a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a>
                                                </span>
                                            </div>
                                        </div>                                        
                                        {{-- <div class="col-md-6 d-flex justify-content-end">
                                            <input type="date" id="tanggalFilter" class="form-control input-custom" style="margin: 0; color: black; width:200px;">
                                        </div>                     --}}
                                    </div>
                                    <thead class="thead-light red-header">
                                        <tr class="custom-p">
                                            <th>No.</th>
                                            <th>Pengunjung</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Subjek</th>
                                            <th>Status</th>
                                            <th>Detail</th> <!-- Add detail column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($combinedData as $data)
                                        <tr class="custom-span riwayat-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data['name'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data['check_in'])->format('d/m/Y H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data['check_out'])->format('d/m/Y H:i') }}</td>
                                                <td>{{ $data['subject'] }}</td>
                                                <td>
                                                    <span class="badge light badge-success">
                                                        <i class="fa fa-circle text-success me-1"></i>
                                                        {{ $data['status'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#kunjunganDetailModal{{ $data['id'] }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a> <!-- Detail button -->
                                                </td>
                                            </tr>

                                            <!-- Modal for Kunjungan Details -->
                                            <div class="modal fade" id="kunjunganDetailModal{{ $data['id'] }}" tabindex="-1" aria-labelledby="kunjunganDetailModalLabel{{ $data['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="kunjunganDetailModalLabel{{ $data['id'] }}">Detail Kunjungan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Pengunjung:</strong> {{ $data['name'] }}</p>
                                                            <p><strong>Check In:</strong> {{ \Carbon\Carbon::parse($data['check_in'])->format('d/m/Y H:i') }}</p>
                                                            <p><strong>Check Out:</strong> {{ \Carbon\Carbon::parse($data['check_out'])->format('d/m/Y H:i') }}</p>
                                                            <p><strong>Subjek:</strong> {{ $data['subject'] }}</p>
                                                            <p><strong>Status:</strong> {{ $data['status'] }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-controls">
                                    <ul class="pagination"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile1" role="tabpanel">
                        <div class="pt-4">
                            <div class="table-responsive">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-6">
                                        <div class="input-group search-area" style="width: 200px;">
                                        <input type="text" id="searchInputKunjungan" class="form-control custom-search-input" placeholder="Search here...">
                                            <span class="input-group-text">
                                                <a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a>
                                            </span>
                                        </div>
                                    </div>                                    
                                    {{-- <div class="col-md-6 d-flex justify-content-end">
                                        <input type="date" id="tanggalFilter" class="form-control input-custom" style="margin: 0; color: black; width:200px;">
                                    </div>                     --}}
                                </div>
                                <table class="table table-responsive-md">
                                    <thead class="thead-light red-header">
                                        <tr class="custom-p">
                                            <th>No.</th>
                                            <th>Subjek</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Detail</th> <!-- Add detail column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allUndangan as $invitation)
                                             <tr class="custom-span riwayat-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $invitation->subject }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invitation->waktu_temu)->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($invitation->status == 'Ditolak')
                                                    <span class="badge light badge-danger">
                                                        <i class="fa fa-circle text-danger me-1"></i>
                                                       {{ $invitation->status }}
                                                    </span>
                                                    @elseif($invitation->status == 'Kadaluarsa')
                                                        <span class="badge light badge-secondary">
                                                            <i class="fa fa-circle text-secondary me-1"></i>
                                                           {{ $invitation->status }}
                                                        </span>
                                                    @elseif($invitation->status == 'Selesai')
                                                        <span class="badge light badge-success">
                                                            <i class="fa fa-circle text-success me-1"></i>
                                                           {{ $invitation->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#undanganDetailModal{{ $invitation->id }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a> <!-- Detail button -->
                                                </td>
                                            </tr>

                                            <!-- Modal for Undangan Details -->
                                            <div class="modal fade" id="undanganDetailModal{{ $invitation->id }}" tabindex="-1" aria-labelledby="undanganDetailModalLabel{{ $invitation->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="undanganDetailModalLabel{{ $invitation->id }}">Detail Undangan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Subjek:</strong> {{ $invitation->subject }}</p>
                                                            <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($invitation->waktu_temu)->format('d/m/Y H:i') }}</p>
                                                            <p><strong>Status:</strong> {{ $invitation->status }}</p>
                                                            <p><strong>Keterangan:</strong> {{ $invitation->keterangan }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-controls">
                                    <ul class="pagination"></ul>
                                </div>
                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById('tanggalFilter').addEventListener('change', function() {
    let selectedDate = this.value; // Mengambil nilai dari input tanggal
    let rows = document.querySelectorAll('.riwayat-row'); // Mengubah pemilihan menjadi kelas riwayat-row

    rows.forEach(row => {
        let checkInDate = row.querySelector('td:nth-child(3)').innerText.trim(); // Mengambil teks dari kolom Check In
        let checkInDateFormatted = moment(checkInDate, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD'); // Mengonversi ke format YYYY-MM-DD

        if (selectedDate === '') {
            row.style.display = ''; // Tampilkan semua baris jika tanggal tidak dipilih
        } else {
            if (checkInDateFormatted === selectedDate) {
                row.style.display = ''; // Tampilkan baris jika tanggal cocok
            } else {
                row.style.display = 'none'; // Sembunyikan baris jika tanggal tidak cocok
            }
        }
    });
});


document.getElementById('searchInputKunjungan').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelectorAll('.riwayat-row');

    rows.forEach(row => {
        let text = row.innerText.toUpperCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

</script>

@endsection
