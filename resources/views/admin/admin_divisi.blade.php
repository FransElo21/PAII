@extends('admin.layouts.main')

@section('content')
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
        border: none;
    }
    .modal-title {
        flex: 1;
    }
</style>

@if(session('success_tambahdivisi'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menambahkan Divisi!',
            text: '{{ session('success_tambahdivisi') }}',
        });
    </script>
@endif

@if(session('success_hapusdivisi'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menghapus Divisi!',
            text: '{{ session('success_hapusdivisi') }}',
        });
    </script>
@endif

@if(session('success_update_divisi'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Memperbarui Divisi!',
            text: '{{ session('success_update_divisi') }}',
        });
    </script>
@endif

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


<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" style="font-size: 45px;">Daftar Divisi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row mb-3">
                <li class="nav-item col-md-3">
                    <div class="input-group search-area">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search here...">
                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                    </div>  
                </li>
                <div class="col-md-6"></div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-success float-end" data-toggle="modal" data-target="#tambahDivisiModal">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
                <br>
                <table class="table table-responsive-md" id="divisiTable">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>No.</strong></th>
                            <th><strong>Nama Divisi</strong></th>
                            <th><strong>Aksi</strong></th>
                        </tr>
                    </thead>
                    <tbody id="divisiTableBody">
                        @php $i = 1 @endphp
                        @foreach($divisis as $divisi)
                        <tr class="custom-span divisi-row" style="color: #828282;">
                            <td><strong>{{ $i++ }}</strong></td>
                            <td>{{ $divisi->nama_divisi }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning shadow btn-xs sharp me-1" onclick="showEditModal({{ $divisi->id }}, '{{ $divisi->nama_divisi }}')"><i class="fa fa-edit"></i></button>
                                    <!-- Tombol Hapus -->
                                    <form id="delete-form-{{ $divisi->id }}" action="{{ route('divisi.destroy', ['id' => $divisi->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="confirmDelete(event, {{ $divisi->id }})" class="btn btn-danger shadow btn-xs sharp" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>                                   
                                </div>                                
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

<!-- Modal Tambah Divisi -->
<div class="modal fade" id="tambahDivisiModal" tabindex="-1" role="dialog" aria-labelledby="tambahDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="tambahDivisiModalLabel"><b>Tambah Divisi Baru</b></h2>
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
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" name="submit">Tambah</button>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>

<!-- Modal Edit Divisi -->
<div class="modal fade" id="editDivisiModal" tabindex="-1" role="dialog" aria-labelledby="editDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="editDivisiModalLabel"><b>Edit Divisi</b></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="edit_nama_divisi">Nama Divisi:</label>
                        <input type="text" class="form-control" id="edit_nama_divisi" name="nama_divisi">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>

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

    function showEditModal(divisiId, namaDivisi) {
        document.getElementById('edit_nama_divisi').value = namaDivisi;
        document.getElementById('editForm').action = `/divisi/${divisiId}`;
        $('#editDivisiModal').modal('show');
    }

    // Fungsi pencarian
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('#divisiTableBody .divisi-row');
        
        rows.forEach(row => {
            let text = row.innerText.toUpperCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        const rowsPerPage = 10;
        const rows = $('#divisiTableBody .divisi-row');
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


@endsection
