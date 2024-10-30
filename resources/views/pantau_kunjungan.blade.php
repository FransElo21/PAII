@extends('layouts.app')

@section('content')
<style>
    .th {
        font-weight: 300;
        color: #333;
        font-size: 15px;
    }

    .td {
        font-size: 15px; /* Ubah nilai ke satuan px */
        color: #333;
    }

    .primary-table-bordered th {
        background-color: #62D9CD; /* Warna latar belakang */
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
</style>
<div class="col-xl-12">
    <div class="card card-shadow">
        <div class="card-header">
            <h2 class="card-title">Pemantauan Kunjungan</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1">Konfirmasi Kunjungan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile1">Sedang Berjalan</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home1" role="tabpanel">
                        <div class="pt-4">
                            @foreach($undangans as $undangan)
                                @if($undangan->status == 'Menunggu')
                                        <div class="card mb-3">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div>{{ $undangan->name }}</div>
                                                <div>{{ $undangan->subject }}</div>
                                                <div>{{ $undangan->time }}</div>
                                                <div>{{ $undangan->status }}</div>
                                            </div>
                                        </div>
                                    @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile1" role="tabpanel">
                        <div class="pt-4">
                            @foreach($undangans as $undangan)
                            @if($undangan->status == 'ditolak') <!-- Sesuaikan kondisi dengan status yang sesuai -->
                                <div class="card mb-3">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>{{ $undangan->host->nama }}</div>
                                        <div>{{ $undangan->subject }}</div>
                                        <div>{{ $undangan->waktu_temu }}</div>
                                        <div>
                                            @if($undangan->status == 'ditolak')
                                            <span class="badge light badge-danger">
                                                <i class="fa fa-circle text-danger me-1"></i>
                                                {{ $undangan->status }}
                                            </span>
                                            @elseif($undangan->status == 'kadaluarsa')
                                                <span class="badge light badge-secondary">
                                                    <i class="fa fa-circle text-secondary me-1"></i>
                                                    {{ $undangan->status }}
                                                </span>
                                            @elseif($undangan->status == 'selesai')
                                                <span class="badge light badge-success">
                                                    <i class="fa fa-circle text-success me-1"></i>
                                                    {{ $undangan->status }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact1">
                        <div class="pt-4">
                            <h4>This is contact title</h4>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.</p>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="message1">
                        <div class="pt-4">
                            <h4>This is message title</h4>
                            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor.</p>
                            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
