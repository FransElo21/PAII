@extends('admin.layouts.main')

@section('content')

@if(session('duplikat'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Terdapat kesalahan!',
            text: '{{ session('duplikat') }}',
        });
    </script>
@endif

<style>
    .custom-span {
        font-weight: 300;
        color: #333;
        font-size: 15px;
    }

    .custom-p {
        font-size: 18px;
        color: white;
        background-color: #355283;
    }

    .card {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        border-radius: 25px;
        overflow: hidden;
        margin-top: 20px;
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
    .modal-title {
        flex: 1;
    }
</style>

@if($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ $errors->first() }}',
        });
    </script>
@endif

@if(session('success_tambahlokasi'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menambahkan Lokasi!',
            text: '{{ session('success_tambahlokasi') }}',
            confirmButtonColor: "#0265F3"
        });
    </script>
@endif

@if(session('success_hapuslokasi'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menghapus Lokasi!',
            text: '{{ session('success_hapuslokasi') }}',
            confirmButtonColor: "#0265F3"
        });
    </script>
@endif

@if(session('success_update_lokasi'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Memperbarui Lokasi!',
            text: '{{ session('success_update_lokasi') }}',
            confirmButtonColor: "#0265F3"
        });
    </script>
@endif

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" style="font-size: 45px;">Daftar Lokasi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row md-3">
                    <li class="nav-item col-md-3">
                        <div class="input-group search-area">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search here...">
                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                        </div>
                    </li>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#tambahLokasiModal">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <br>
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>No.</strong></th>
                            <th><strong>Lantai</strong></th>
                            <th><strong>Ruangan</strong></th>
                            <th><strong>Aksi</strong></th>
                        </tr>
                    </thead>
                    <tbody id="lokasiTableBody">
                        @php $i = 1 @endphp
                        @foreach($lokasis as $lokasi)
                        <tr class="custom-span lokasi-row" style="color:#828282;">
                            <td><strong>{{ $i++ }}</strong></td>
                            <td>{{ $lokasi->lantai }}</td>
                            <td>{{ $lokasi->ruangan }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-warning shadow btn-xs sharp me-1" onclick="showEditModal({{ $lokasi->id }}, '{{ $lokasi->lantai }}', '{{ $lokasi->ruangan }}')"><i class="fa fa-edit"></i></button>
                                    <form id="delete-form-{{ $lokasi->id }}" action="{{ route('lokasi.destroy', $lokasi->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="confirmDelete(event, {{ $lokasi->id }})" class="btn btn-danger shadow btn-xs sharp" type="submit"><i class="fa fa-trash"></i></button>
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

<!-- Modal Edit Lokasi -->
<div class="modal fade" id="editLokasiModal" tabindex="-1" role="dialog" aria-labelledby="editLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="editLokasiModalLabel"><b>Edit Lokasi</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_lantai">Lantai:</label>
                        <input type="text" class="form-control" id="edit_lantai" name="lantai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_ruangan">Ruangan:</label>
                        <input type="text" class="form-control" id="edit_ruangan" name="ruangan" required>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Lokasi -->
<div class="modal fade" id="tambahLokasiModal" tabindex="-1" role="dialog" aria-labelledby="tambahLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="tambahLokasiModalLabel"><b>Tambah Lokasi Baru</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lokasi.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="lantai">Lantai:</label>
                        <input type="text" class="form-control" id="lantai" name="lantai" required>
                    </div>
                    <div class="form-group">
                        <label for="ruangan">Ruangan:</label>
                        <input type="text" class="form-control" id="ruangan" name="ruangan" required>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showEditModal(lokasiId, lantai, ruangan) {
        document.getElementById('edit_lantai').value = lantai;
        document.getElementById('edit_ruangan').value = ruangan;
        document.getElementById('editForm').action = `/lokasi/${lokasiId}`;
        $('#editLokasiModal').modal('show');
    }

    function confirmDelete(event, lokasiId) {
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
                document.getElementById('delete-form-' + lokasiId).submit(); // Mengirimkan formulir DELETE jika pengguna mengonfirmasi
            }
        });
    }

    // Fungsi pencarian
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('#lokasiTableBody .lokasi-row');

        rows.forEach(row => {
            let text = row.innerText.toUpperCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

@endsection
