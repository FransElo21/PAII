@extends('host.layouts.main')

@section('content')
<div class="content-container">
    <span class="card-title">Hello, <b>{{ Auth::guard('host')->user()->username }}</b></span>
    <h4 class="card-title">Ingin Melakukan Kunjungan</h4>

    @if ($undangans->isEmpty() || $undangans->where('host_id', Auth::guard('host')->id())->isEmpty())
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
                    <thead>
                        <tr class="th">
                            <th>No</th>
                            <th>Nama Pengunjung</th>
                            <th>Subjek</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach($undangans as $undangan)
                            <tr class="td">
                                <td>{{ $i++ }}</td>
                                <td>{{ $undangan->pengunjung->namaLengkap }}</td>
                                <td>{{ $undangan->subject }}</td>
                                <td>{{ $undangan->waktu_temu }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Aksi">
                                        <form method="POST" action="{{ route('accept.show', ['undangan_id' => $undangan->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm mr-1">Terima</button>
                                        </form>
                                        
                                        {{-- <a href="{{ route('undangan.edit', ['undangan_id' => $undangan->id]) }}" class="btn btn-primary btn-sm">Tambahkan Lokasi dan Edit Waktu</a> --}}
                                                                              
                                        <form method="POST" action="{{ route('reject.undangan') }}">
                                            @csrf
                                            <input type="hidden" name="undangan_id" value="{{ $undangan->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                        </form>
                                    </div>
                                </td>                                                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="content-container">
    <div class="row mt-4">
        <div class="">
            <img src="{{ asset('images/beranda-prosedur2.jpg') }}" class="img-fluid rounded" alt="Foto Anda">
        </div>
    </div>
</div>
@endsection
