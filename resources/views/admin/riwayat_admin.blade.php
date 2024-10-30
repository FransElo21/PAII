@extends('admin.layouts.main')

@section('content')
<style>
    .modal-title {
    font-weight: 600; /* Semibold biasanya memiliki nilai 600 */
    }
    
    /* Gaya yang ada sebelumnya */
    .custom-span {
        font-weight: 300;
        color: #333;
        font-size: 15px;
    }

    .custom-p {
        color: white;
        background-color: #355283;
    }

    .card {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        border-radius: 25px;
        overflow: hidden;
        margin-top: 20px;
        background-color: #fff;
    }

    .btn {
        border-radius: 20px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .form-select.custom-red {
        background-color: #c9121c;
        color: white;
        height: calc(3em + 0.75rem + 2px);
    }

    .form-select.custom-red option {
        color: black;
    }

    .search-area .form-control {
        height: calc(2.5em + 0.75rem + 2px);
    }

    .btn-custom,
    .input-custom,
    .select-custom {
        width: 150px; /* Atur lebar tombol, input, dan dropdown filter */
    }

    /* Responsif */
    @media (max-width: 768px) {
        .btn-custom,
        .input-custom,
        .select-custom {
            width: 100%; /* Ubah lebar menjadi 100% pada layar kecil */
        }
    }

    /* Gaya untuk ikon kalender dan dropdown */
    .form-control[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }

    .form-select::after {
        content: '\25BC'; /* Unicode untuk ikon dropdown (panah ke bawah) */
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: white; /* Ubah warna ikon dropdown menjadi putih */
    }
    .modal-body .row {
        margin-bottom: 10px; /* Atur jarak antar elemen */
    }
</style>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" style="font-size: 45px;">Riwayat</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="d-flex align-items-end justify-content-end">
                        <div class="input-group search-area" style="width: 250px">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search here...">
                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                        </div>
                        <select id="statusFilter" class="form-select custom-red select-custom me-2 ms-auto" aria-label="Filter" style="background-color:#40A752;">
                            <option value="">Status</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Kadaluarsa">Kadaluarsa</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                        <a href="{{ route('riwayat.cetak2') }}" class="btn btn-primary btn-custom me-2" target="_blank" style="background-color: #828282; border-color: #828282;">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                        <input type="date" id="tanggalFilter" class="form-control input-custom" style="margin: 0; color: #FFF; background-color:#40A752;">
                    </div>    
                </div>
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>No.</strong></th>
                            <th><strong>Visitor</strong></th>
                            <th><strong>Host</strong></th>
                            <th><strong>Subjek</strong></th>
                            <th><strong>Waktu</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Aksi</strong></th>
                        </tr>
                    </thead>
                    <tbody id="riwayatTableBody">
                        @php $i = 1 @endphp
                        @foreach ($undangan as $item)
                        <tr class="custom-span riwayat-row" style="color:#828282;">
                            <td><strong>{{ $i++ }}</strong></td>
                            <td>{{ $item->pengunjung->namaLengkap }}</td>
                            <td>{{ $item->host->nama }}</td>
                            <td>{{ $item->subject }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->waktu_temu)->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($item->status == 'Ditolak')
                                <span class="badge light badge-danger">
                                    <i class="fa fa-circle text-danger me-1"></i>
                                    {{ $item->status }}
                                </span>
                                @elseif($item->status == 'Kadaluarsa')
                                    <span class="badge light badge-secondary">
                                        <i class="fa fa-circle text-secondary me-1"></i>
                                        {{ $item->status }}
                                    </span>
                                @elseif($item->status == 'Selesai')
                                    <span class="badge light badge-success">
                                        <i class="fa fa-circle text-success me-1"></i>
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol detail -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#undanganDetailModal{{ $item->id }}" class="btn btn-primary shadow btn-xs sharp me-1"  style="background-color: #2E3A59; border-color: #2E3A59;" >
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Kontrol Pagination -->
                <div class="pagination-controls">
                    <ul class="pagination"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($undangan as $item)
<!-- Modal -->
<div class="modal fade" id="undanganDetailModal{{ $item->id }}" tabindex="-1" aria-labelledby="undanganDetailModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="undanganDetailModalLabel{{ $item->id }}">Riwayat</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-5">Visitor</div>
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
                        <div class="col-6">{{ \Carbon\Carbon::parse($item->waktu_kembali)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Keperluan</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->subject }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5">Jenis Kunjungan</div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->type }}</div>
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
                        <div class="col-5">Check in</div>
                        <div class="col-1">:</div>
                        <div class="col-6">
                            {{ $item->logs->check_in ? \Carbon\Carbon::parse($item->logs->check_in)->format('H:i') : '-' }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">Check out</div>
                        <div class="col-1">:</div>
                        <div class="col-6">
                            {{ $item->logs->check_out ? \Carbon\Carbon::parse($item->logs->check_out)->format('H:i') : '-' }}
                        </div>
                    </div>                                      
                    <div class="row">
                        <div class="col-5">Status</div>
                        <div class="col-1">:</div>
                        <div class="col-6">
                            @if($item->status == 'Ditolak')
                                <span class="badge light badge-danger">
                                    <i class="fa fa-circle text-danger me-1"></i>
                                    {{ $item->status }}
                                </span>
                                @elseif($item->status == 'Kadaluarsa')
                                    <span class="badge light badge-secondary">
                                        <i class="fa fa-circle text-secondary me-1"></i>
                                        {{ $item->status }}
                                    </span>
                                @elseif($item->status == 'Selesai')
                                    <span class="badge light badge-success">
                                        <i class="fa fa-circle text-success me-1"></i>
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
<!-- End of Modal -->
@endforeach

<script>
    // Fungsi pencarian
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('#riwayatTableBody .riwayat-row');

        rows.forEach(row => {
            let text = row.innerText.toUpperCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Fungsi filter status
    document.getElementById('statusFilter').addEventListener('change', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('#riwayatTableBody .riwayat-row');

        rows.forEach(row => {
            let status = row.querySelector('td:nth-child(6) .badge').innerText.toUpperCase();
            row.style.display = filter === '' || status.includes(filter) ? '' : 'none';
        });
    });
</script>

<script>
    document.getElementById('tanggalFilter').addEventListener('change', function() {
        let selectedDate = this.value; // Mengambil nilai dari input tanggal
        let rows = document.querySelectorAll('#riwayatTableBody .riwayat-row');

        rows.forEach(row => {
            let waktuTemu = row.querySelector('td:nth-child(5)').innerText.trim(); // Mengambil teks dari kolom Waktu
            let waktuTemuFormatted = moment(waktuTemu, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD'); // Mengonversi ke format YYYY-MM-DD

            if (selectedDate === '') {
                row.style.display = ''; // Tampilkan semua baris jika tanggal tidak dipilih
            } else {
                if (waktuTemuFormatted === selectedDate) {
                    row.style.display = ''; // Tampilkan baris jika tanggal cocok
                } else {
                    row.style.display = 'none'; // Sembunyikan baris jika tanggal tidak cocok
                }
            }
        });
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

@endsection
