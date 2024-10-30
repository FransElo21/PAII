@extends('host.layouts.main')

@section('content')
@if(session('konfirmasi_berhasil'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success Mengkonfirmasi Undangan!',
        text: '{{ session('success_updatehost') }}',
    });
</script>
@endif
<style>
    /* Gaya CSS tambahan di sini */
</style>
<div class="col-xl-12">
    <div class="card card-shadow">
        <div class="card-header">
            <h2 class="card-title">Konfirmasi Kunjungan</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1">Kunjungan hari ini</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home1" role="tabpanel">
                        <div class="pt-4">
                            @foreach($undangans as $undangan)
                                @if($undangan->status == 'Menunggu')
                                    <div class="card mb-3">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>{{ $undangan->pengunjung->namaLengkap }}</div>
                                            <div>{{ $undangan->subject }}</div>
                                            <div>{{ \Carbon\Carbon::parse($undangan->waktu_temu)->format('d/m/Y H:i') }}</div>
                                            <div>
                                                {{-- <a href="{{ route('detail.undangan', $undangan->id) }}" class="btn btn-primary btn-sm">Detail</a> --}}
                                                <a href="{{ route('detail_host.undangan', ['id' => $undangan->id]) }}" class="btn btn-success btn-sm">Detail</a>
                                            </div>
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
                                                <a href="{{ route('detail.undangan', $undangan->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact1">
                        <!-- Konten untuk tab "Contact" -->
                    </div>
                    <div class="tab-pane fade" id="message1">
                        <!-- Konten untuk tab "Message" -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
