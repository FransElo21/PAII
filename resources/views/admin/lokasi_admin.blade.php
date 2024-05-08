@extends('admin.layouts.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Lokasi</h4>
            <a href="tambah_lokasi" class="btn btn-success float-start">
                <i class="fas fa-plus"></i> Tambah
            </a>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>No.</strong></th>
                            <th><strong>Ruangan</strong></th>
                            <th><strong>Lantai</strong></th>
                            <th><strong>Aksi</strong></th> <!-- Tambah kolom untuk tombol aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach($lokasis as $lokasi)
                        <tr class="custom-span">
                            <td><strong>{{ $i++ }}</strong></td>
                            <td>{{ $lokasi->ruangan }}</td>
                            <td>{{ $lokasi->lantai }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-primary shadow btn-xs sharp me-1" onclick="editDivisi()">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-" action="" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="confirmDelete(event, )" class="btn btn-danger shadow btn-xs sharp" type="submit"><i class="fa fa-trash"></i></button>
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
</div>

@endsection