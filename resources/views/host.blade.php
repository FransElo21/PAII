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
</style>


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Host</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table primary-table-bordered">
                    <thead class="">
                        @php $i = 1 @endphp
                        <tr class="th">
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hosts as $host)
                        <tr class="td">
                            <td>{{ $i++ }}</td>
                            <td>
                                    <div class="d-flex align-items-center">
                                            <img src="{{ asset($host->foto_profil) }}" class="rounded-lg me-2" width="60" alt="">
                                    </div>
                            </td>
                            <td>{{ $host->nama }}</td>  
                            <td>{{ $host->email }}</td>
                            <td>0{{ $host->nomor_telepon }}</td>
                            <td>{{ $host->divisi->nama_divisi }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection