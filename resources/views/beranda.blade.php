@extends('layouts.app')

@section('content')
<style>
    .cover-photo {
        position: relative;
        width: 100%;
        height: 350px; /* Atur tinggi sesuai kebutuhan */
        overflow: hidden; /* Menghindari gambar melampaui batas */
        border-radius: 10px; /* Tambahkan border radius di sini */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Tambahkan shadow */
    }

    .cover-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Memastikan gambar memenuhi bagian div */
        border-radius: 10px; /* Tambahkan border radius di sini */
    }

    .custom-span {
        font-weight: 600; /* Atur tebal huruf */
        color: #333; /* Atur warna teks */
        font-size: 15px;
    }

    .custom-p {
        font-size: 1.2em; /* Atur ukuran teks */
        color: #333; /* Atur warna teks */
    }

    .content-container {
        padding: 20px; /* Tambahkan padding untuk memisahkan konten */
    }

    .primary-table-bordered th {
        background-color: #62D9CD; /* Warna latar belakang */
        color: #fff; /* Warna teks */
    }

    .card-title {
        font-size: 1.4em; /* Ubah ukuran font */
        margin-bottom: 1em; /* Ubah margin */
    }

    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Tambahkan shadow */
    }

    .card-header {
        background-color: #62D9CD;
        color: #fff;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 20px;
        
    }

    .table {
        border-radius: 10px;
    }
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.5em; /* Atur ukuran font untuk layar kecil */
        }

        .custom-p {
            font-size: 1em; /* Atur ukuran teks untuk layar kecil */
        }
    }
</style>

<div class="content-container">
    <span class="card-title">Hello, <b>{{ Auth::user()->username }}</b></span>
    <h4 class="card-title">Ingin Melakukan Kunjungan</h4>

    @if ($undangans->isEmpty() || $undangans->where('pengunjung_id', Auth::id())->isEmpty())
    <div class="row cover-photo">
        <img src="{{ asset('images/aktifitas1.jpg') }}" class="img-fluid" alt="Foto Anda">
    </div>
    @else
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Aktifitas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table primary-table-bordered">
                    <thead class="">
                        @php $i = 1 @endphp
                        <tr class="th">
                            <th>No</th>
                            <th>Nama Host</th>
                            <th>Subjek</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th> <!-- Tambahkan kolom Aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($undangans as $Undangan)
                            @if($Undangan->pengunjung_id == Auth::id())
                                <tr class="td">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $Undangan->host->nama }}</td>
                                    <td>{{ $Undangan->subject }}</td>
                                    <td>0{{ $Undangan->waktu_temu }}</td>
                                    <td><span class="badge light badge-warning">{{ $Undangan->status }}</td>
                                    <td>
                                        <a href="{{ route('detail_undangan.show', ['id' => $Undangan->id]) }}" class="btn btn-primary btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        <div class="row mt-4">
            <div class="">
                <img src="{{ asset('images/beranda-prosedur2.jpg') }}" class="img-fluid rounded" alt="Foto Anda">
            </div>
        </div>
    
    @endif
</div>

@endsection
