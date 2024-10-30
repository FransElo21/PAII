@extends('layouts.app')

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
        background-color: #62D9CD;
        color: white;
        height: calc(3em + 0.75rem + 2px);
    }

    .form-select.custom-red option {
        color: black;
    }

    .search-area .form-control {
        height: calc(2.5em + 0.75rem + 2px);
    }

    .custom-p {
        background-color: #F20800;
    }

    .btn-custom,
    .input-custom,
    .select-custom {
        width: 150px;
    }

    /* Custom width for search input */
    .custom-search-input {
        width: 250px; /* Set desired width */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-custom,
        .input-custom,
        .select-custom,
        .custom-search-input {
            width: 100%; /* Full width on small screens */
        }
    }
</style>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Riwayat</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-6">
                        <div class="input-group search-area" style="width: 200px;">
                            <input type="text" id="searchInput" class="form-control custom-search-input" placeholder="Search here...">
                            <span class="input-group-text">
                                <a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <input type="date" id="tanggalFilter" class="form-control input-custom" style="margin: 0; color: black;">
                    </div>                    
                </div>
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>No.</strong></th>
                            <th><strong>Nama Host</strong></th>
                            <th><strong>Subjek</strong></th>
                            <th><strong>Waktu</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Aksi</strong></th>
                        </tr>
                    </thead>
                    <tbody id="riwayatTableBody">
                        @php $i = 1 @endphp
                        @foreach ($undangan as $item)
                        <tr class="custom-span riwayat-row">
                            <td><strong>{{ $i++ }}</strong></td>
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
                                <a href="#" data-bs-toggle="modal" data-bs-target="#undanganDetailModal{{ $item->id }}" class="btn btn-primary shadow btn-xs sharp me-1">
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
                <h5 class="modal-title" id="undanganDetailModalLabel{{ $item->id }}">Riwayat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-5"><b>Nama Lengkap</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->pengunjung->namaLengkap }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Host</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->host->nama }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Divisi</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->host->divisi->nama_divisi }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Kunjungan dari</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->kunjungan_dari }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Waktu Temu</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ \Carbon\Carbon::parse($item->waktu_temu)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Waktu Kembali</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ \Carbon\Carbon::parse($item->waktu_kembali)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Keperluan</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->subject }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Jenis Kunjungan</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->type }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Ruangan</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->lokasi->ruangan }} {{ $item->lokasi->lantai }}</div>

                    </div>
                    <div class="row">
                        <div class="col-5"><b>Nomor Telepon</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->pengunjung->nomor_telepon }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Email</b></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $item->pengunjung->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5"><b>Status</b></div>
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
                    @if($item->status == 'Ditolak')
                                <div class="row">
                                    <div class="col-5"><b>Alasan Penolakan</b></div>
                                    <div class="col-1">:</div>
                                    <div class="col-6">{{ $item->alasan_penolakan }}</div>
                                </div>
                                @endif 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            let status = row.querySelector('td:nth-child(5) .badge').innerText.toUpperCase();
            row.style.display = filter === '' || status.includes(filter) ? '' : 'none';
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const rowsPerPage = 10;
        const rows = $('#riwayatTableBody .riwayat-row');
        const rowsCount = rows.length;
        const pageCount = Math.ceil(rowsCount / rowsPerPage);
        const paginationControls = $('.pagination-controls .pagination');

        function displayRows(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            rows.hide();
            rows.slice(start, end).show();
        }

        function buildPagination() {
            paginationControls.empty();
            for (let i = 1; i <= pageCount; i++) {
                paginationControls.append(`<li class="page-item"><a href="#" class="page-link">${i}</a></li>`);
            }
        }

        paginationControls.on('click', 'a', function (e) {
            e.preventDefault();
            const page = $(this).text();
            displayRows(page);
            $(this).closest('li').addClass('active').siblings().removeClass('active');
        });

        // Initialize
        displayRows(1);
        buildPagination();
        paginationControls.find('li:first-child').addClass('active');
    });
</script>

<script>
    document.getElementById('tanggalFilter').addEventListener('change', function() {
    let selectedDate = this.value; // Mengambil nilai dari input tanggal
    let rows = document.querySelectorAll('#riwayatTableBody .riwayat-row');

    rows.forEach(row => {
        let waktuTemu = row.querySelector('td:nth-child(4)').innerText.trim(); // Mengambil teks dari kolom Waktu
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

@endsection
