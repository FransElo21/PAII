@extends('admin.layouts.main')

@section('content')
<style>
    .custom-span {
        font-weight: 300; /* Atur tebal huruf */
        color: #333; /* Atur warna teks */
        font-size: 15px;
    }

    .custom-p {
        font-size: 18px; /* Atur ukuran teks */
        color: #333; /* Atur warna teks */
    }
</style>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Divisi</h4>
            <button type="button" class="btn btn-success float-start" data-toggle="modal" data-target="#tambahDivisiModal">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>NO.</strong></th>
                            <th><strong>Nama Divisi</strong></th>
                            <th><strong>Aksi</strong></th> <!-- Tambah kolom untuk tombol aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach($divisis as $divisi)
                        <tr class="custom-span">
                            <td><strong>{{ $i++ }}</strong></td>
                            <td>{{ $divisi->nama_divisi }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-primary shadow btn-xs sharp me-1" onclick="editDivisi({{ $divisi->id }}, '{{ $divisi->nama_divisi }}')">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $divisi->id }}" action="{{ route('divisi.destroy', ['id' => $divisi->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="confirmDelete(event, {{ $divisi->id }})" class="btn btn-danger shadow btn-xs sharp" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>                                    
                                </div>
                            </td>
                        </tr>
                        <tr id="editRow{{ $divisi->id }}" style="display: none;">
                            <td colspan="3">
                                <form id="editForm{{ $divisi->id }}" onsubmit="updateDivisi(event, {{ $divisi->id }})">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <input type="text" name="nama_divisi" class="form-control" value="{{ $divisi->nama_divisi }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" onclick="cancelEdit({{ $divisi->id }})">Batal</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahDivisiModal" tabindex="-1" role="dialog" aria-labelledby="tambahDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDivisiModalLabel">Tambah Divisi Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('divisi.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_divisi">Nama Divisi:</label>
                        <input type="text" class="form-control" id="nama_divisi" name="nama_divisi">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional if you need modal functionality with JavaScript) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- SweetAlert2 for delete confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function confirmDelete(event, divisiId) {
        event.preventDefault(); // Mencegah pengiriman formulir secara langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak akan dapat mengembalikan data ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + divisiId).submit(); // Mengirimkan formulir DELETE jika pengguna mengonfirmasi
            }
        });
    }
</script>

@endsection
