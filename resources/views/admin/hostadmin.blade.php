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
            <h4 class="card-title">Daftar Host</h4>
            <a href="tambahhost" class="btn btn-success float-start"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>NO.</strong></th>
                            <th><strong>Name</strong></th>
                            <th><strong>Username</strong></th>
                            <th><strong>Email</strong></th>
                            <th><strong>No.Telepon</strong></th>
                            <th><strong>Divisi</strong></th>
                            <th><strong></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach($hosts as $host)
                        <tr class="custom-span">
                            <td><strong>{{ $i++ }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($host->foto_profil)
                                        <img src="{{ asset($host->foto_profil) }}" class="rounded-lg me-2" width="24" alt="">
                                    @else
                                        <img src="{{ asset('images/avatar/1.jpg') }}" class="rounded-lg me-2" width="24" alt="">
                                    @endif
                                    {{ $host->nama }}
                                    <span class="w-space-no"></span>
                                </div>
                            </td>
                            <td>{{ $host->username }}</td>
                            <td>{{ $host->email }}</td>
                            <td>0{{ $host->nomor_telepon }}</td>
                            <td><div class="d-flex align-items-center">{{ $host->divisi->nama_divisi }}</div></td>
                            <td>
                                <div class="d-flex">                                  
                                    <a href="{{ route('host.detail', $host->id) }}" class="btn btn-primary shadow btn-xs sharp me-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>                                    
                                    {{-- <button onclick="deleteHost({{ $host->id }})" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button> --}}
                                    <form id="delete-form-{{ $host->id }}" action="{{ route('hostadmin.destroy', $host->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="confirmDelete(event, {{ $host->id }})" class="btn btn-danger shadow btn-xs sharp" type="submit"><i class="fa fa-trash"></i></button>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function confirmDelete(event, hostId) {
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
                document.getElementById('delete-form-' + hostId).submit(); // Mengirimkan formulir DELETE jika pengguna mengonfirmasi
            }
        });
    }
</script>


@endsection


