@extends('host.layouts.main')

@section('content')
<style>
    .card {
        border-radius: 30px;
        box-shadow: 0 10px 16px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border-radius: 20px;
        border-color: #ccc;
    }

    .form-group h4 {
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        border-radius: 20px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .btn-success {
        border-radius: 20px;
    }

    .card-header {
        color: white;
        font-size: 25px;
        border-radius: 25px;
        padding: 20px 0;
        text-align: center;
    }

    .group-member {
        margin-bottom: 10px;
    }

    .remove-visitor {
        margin-top: 30px;
    }
</style>
@if(session('buat_undangan_berhasil'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success Membuat Undangan!',
            text: '{{ session('success_updatehost') }}',
        });
    </script>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container mt-5">
    <form action="{{ route('undangan_host.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header" style="justify-content: center">
                <h2 class="card-title mb-2" style="font-size:27px;"><b>Form Undangan</b></h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required>
                    </div>
                    <div class="col-md-6">
                        <select name="keperluan" id="keperluan" class="form-control" required>
                            <option value="" disabled selected>Keperluan</option>
                            <option value="Pribadi">Pribadi</option>
                            <option value="Pekerjaan">Pekerjaan</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="kunjungan_dari" name="kunjungan_dari" class="form-control" placeholder="Kunjungan Dari" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="waktu_temu" class="form-label">Waktu Temu</label>
                        <input type="datetime-local" id="waktu_temu" name="waktu_temu" class="form-control" placeholder="Waktu Temu" required>
                    </div>
                    <div class="col-md-6">
                        <label for="waktu_kembali" class="form-label">Waktu Kembali</label>
                        <input type="datetime-local" id="waktu_kembali" name="waktu_kembali" class="form-control" placeholder="Waktu Kembali">
                    </div>
                </div>
                <div id="groupMembers">
                    <h4>Pengunjung</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="visitors[0][name]" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="visitors[0][email]" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="visitors[0][phone]" class="form-control" placeholder="Phone" pattern="^\+62\d{9,15}$" title="Format nomor telepon harus dimulai dengan +62 dan memiliki panjang 10-16 karakter" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="visitors[0][NIK]" class="form-control" placeholder="NIK" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="addVisitor" class="btn btn-secondary rounded-pill">Tambah Pengunjung</button>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="text-align: center">
                <button type="submit" class="btn btn-success rounded-pill">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let visitorCount = 1;
        
        document.getElementById('addVisitor').addEventListener('click', function () {
            var groupMembers = document.getElementById('groupMembers');
            var newVisitor = document.createElement('div');
            newVisitor.classList.add('row', 'mb-3', 'group-member');
            newVisitor.innerHTML = `
                <div class="col-md-2">
                    <input type="text" name="visitors[${visitorCount}][name]" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-2">
                    <input type="email" name="visitors[${visitorCount}][email]" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="visitors[${visitorCount}][phone]" class="form-control" placeholder="Phone" pattern="^\\+62\\d{9,15}$" title="Format nomor telepon harus dimulai dengan +62 dan memiliki panjang 10-16 karakter" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="visitors[${visitorCount}][NIK]" class="form-control" placeholder="NIK" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-visitor">Remove</button>
                </div>
            `;
            groupMembers.appendChild(newVisitor);
            visitorCount++;
        });

        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-visitor')) {
                var memberToRemove = event.target.closest('.group-member');
                memberToRemove.remove();
            }
        });
    });
</script>
<script>
    // Mengatur tanggal dan waktu minimum untuk input waktu_temu dan waktu_kembali
    var now = new Date().toISOString().slice(0, 16); // Format: YYYY-MM-DDTHH:mm
    document.getElementById('waktu_temu').setAttribute('min', now);
    document.getElementById('waktu_kembali').setAttribute('min', now);

    // Ketika pengguna memilih tanggal atau waktu pada input waktu_temu
    document.getElementById('waktu_temu').addEventListener('change', function () {
        // Mendapatkan nilai input
        var selectedDateTime = new Date(this.value).getTime();
        var nowDateTime = new Date().getTime();

        // Membandingkan dengan waktu saat ini
        if (selectedDateTime < nowDateTime) {
            alert('Waktu tidak dapat dipilih sebelum waktu saat ini.');
            this.value = now; // Kembalikan ke nilai minimum jika memilih waktu sebelum waktu saat ini
        }
    });

    // Ketika pengguna memilih tanggal atau waktu pada input waktu_kembali
    document.getElementById('waktu_kembali').addEventListener('change', function () {
        // Mendapatkan nilai input
        var selectedDateTime = new Date(this.value).getTime();
        var nowDateTime = new Date().getTime();

        // Membandingkan dengan waktu saat ini
        if (selectedDateTime < nowDateTime) {
            alert('Waktu tidak dapat dipilih sebelum waktu saat ini.');
            this.value = now; // Kembalikan ke nilai minimum jika memilih waktu sebelum waktu saat ini
        }
    });
</script>
@endsection
