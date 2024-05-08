@if($host)
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Detail Host</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $host->nama }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $host->username }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $host->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>0{{ $host->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $host->email }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $host->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Divisi</th>
                            <td>{{ $host->divisi->nama_divisi }}</td>
                        </tr>
                        <tr>
                            <th>Foto Profil</th>
                            <td>
                                @if($host->foto_profil)
                                <img src="{{ asset($host->foto_profil) }}" class="img-thumbnail" alt="Foto Profil">
                                @else
                                <p>Foto Profil Tidak Tersedia</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="{{ route('hostadmin.show') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>
@else
<p>Data host tidak ditemukan.</p>
@endif
