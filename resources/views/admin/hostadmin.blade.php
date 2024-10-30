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
    }

    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .custom-detail {
        font-size: 15px;
    }
</style>

@if(session('success_tambahhost'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menambahkan Host!',
            text: '{{ session('success_tambahhost') }}',
            confirmButtonColor: "#0265F3"
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

@if(session('success_hapushost'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Menghapus Data Host!',
            text: '{{ session('success_hapushost') }}',
            confirmButtonColor: "#0265F3"
        });
    </script>
@endif

@if(session('success_updatehost'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Memperbaharui Data Host!',
            text: '{{ session('success_updatehost') }}',
            confirmButtonColor: "#0265F3"
        });
    </script>
@endif

<div class="col-lg-12 fade-up">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title" style="font-size: 45px;">Daftar Host</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row mb-3">
                    <li class="nav-item col-md-3">
                        <div class="input-group search-area" style="width: 250px">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search here...">
                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                        </div>                       
                    </li>
                    <div class="col-md-6"></div>
                    <div class="col-md-3">
                        <button class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#tambahHostModal">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>                    
                </div>
                <br>
                <table class="table table-responsive-md">
                    <thead>
                        <tr class="custom-p">
                            <th><strong>No.</strong></th>
                            <th><strong>Nama Lengkap</strong></th>
                            <th><strong>Divisi</strong></th>
                            <th><strong>Lokasi</strong></th>
                            <th><strong>Aksi</strong></th>
                        </tr>
                    </thead>
                    <tbody id="hostTableBody">
                        @php $i = 1 @endphp
                        @foreach($hosts as $host)
                        <tr class="custom-span host-row fade-up">
                            <td><strong style="color: #828282;">{{ $i++ }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center" style="color: #828282;">
                                    @if($host->foto_profil)
                                        <img src="{{ asset($host->foto_profil) }}" class="rounded-lg me-2" width="24" alt="">
                                    @else
                                        <img src="{{ asset('images/avatar/1.jpg') }}" class="rounded-lg me-2" width="24" alt="">
                                    @endif
                                    {{ $host->nama }}
                                    <span class="w-space-no"></span>
                                </div>
                            </td>
                            <td><div class="d-flex align-items-center" style="color: #828282;">{{ $host->divisi->nama_divisi }}</div></td>
                            <td><div class="d-flex align-items-center" style="color: #828282;">{{ $host->lokasi->ruangan }} {{ $host->lokasi->lantai }}</div></td>
                            <td>
                                <div class="d-flex">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#hostDetailModal{{ $host->id }}" class="btn btn-primary shadow btn-xs sharp me-1" style="background-color: #2E3A59; border-color: #2E3A59;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-warning shadow btn-xs sharp me-1" onclick="showEditHostModal('{{ $host->id }}', '{{ $host->nama }}', '{{ $host->username }}', '{{ $host->alamat }}', '{{ $host->nomor_telepon }}', '{{ $host->email }}', '{{ $host->jenis_kelamin }}', '{{ $host->divisi_id }}', '{{ $host->lokasi_id }}')">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                                                                      
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

@foreach($hosts as $host)
<!-- Modal -->
<div class="modal fade" id="hostDetailModal{{ $host->id }}" tabindex="-1" aria-labelledby="hostDetailModalLabel{{ $host->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="hostDetailModalLabel{{ $host->id }}"><b>Detail Host</b></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> 
                <div class="text-center">
                    <img src="{{ $host->foto_profil ? asset($host->foto_profil) : asset('images/avatar/1.jpg') }}" class="rounded-lg" width="100" alt="Foto Profil">
                </div>
                <div class="container mt-4 custom-detail">
                    <div class="row mb-3">
                        <div class="col-5"><strong>Nama</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->nama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Username</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->username }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Jenis Kelamin</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->jenis_kelamin }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Nomor Telepon</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">+62{{ $host->nomor_telepon }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Email</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Alamat</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->alamat }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Lokasi</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->lokasi->ruangan }}  {{ $host->lokasi->lantai }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"><strong>Divisi</strong></div>
                        <div class="col-1">:</div>
                        <div class="col-6">{{ $host->divisi->nama_divisi }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <!-- Jika Anda ingin menambahkan tombol aksi di modal, letakkan di sini -->
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->
@endforeach

<div class="modal fade" id="tambahHostModal" tabindex="-1" aria-labelledby="tambahHostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            <h2 class="modal-title text-center" id="tambahHostModalLabel"><b>Tambah Host</b></h2>
            <div class="modal-body">
                <form method="POST" action="{{ route('Tambah_host.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>

                    <div class="form-group mb-3 position-relative">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
                    </div>

                    <div class="form-group mb-3 position-relative">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePasswordConfirmation" style="cursor: pointer;"></i>
                    </div>

                    <div class="form-group mb-3">
                        <div class="radio-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" required>
                                <label class="form-check-label" for="laki-laki">
                                    <i class="bi bi-gender-male"></i> Laki-laki
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                                <label class="form-check-label" for="perempuan">
                                    <i class="bi bi-gender-female"></i> Perempuan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <input type="tel" class="form-control" id="phone" name="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="Nomor Telepon" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group mb-3">
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <select class="form-control" id="divisi" name="divisi_id">
                            <option value="" disabled selected>Divisi</option>
                            @foreach ($divisis as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="form-group mb-3">
                        <select class="form-control" id="lokasi" name="lokasi_id">
                            <option value="" disabled selected>Lokasi</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}">{{ $lokasi->ruangan }} {{ $lokasi->lantai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Host -->
<div class="modal fade" id="editHostModal" tabindex="-1" role="dialog" aria-labelledby="editHostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h2 class="modal-title text-center" id="editHostModalLabel"><b>Ubah Data Host</b></h2>
            <div class="modal-body">
                <form id="editForm" method="POST" action="{{ route('host.update', $hosts->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="edit_nama" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="edit_username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="edit_alamat" name="alamat" placeholder="Alamat" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <input type="tel" class="form-control" id="edit_nomor_telepon" name="nomor_telepon" placeholder="Nomor Telepon" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="radio-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit_jenis_kelamin_laki_laki" value="Laki-laki" required>
                                <label class="form-check-label" for="edit_jenis_kelamin_laki_laki">
                                    <i class="bi bi-gender-male"></i> Laki-laki
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="edit_jenis_kelamin_perempuan" value="Perempuan" required>
                                <label class="form-check-label" for="edit_jenis_kelamin_perempuan">
                                    <i class="bi bi-gender-female"></i> Perempuan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-control" id="edit_divisi" name="divisi_id" required>
                            <option value="" disabled>Divisi</option>
                            @foreach ($divisis as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-control" id="edit_lokasi" name="lokasi_id" required>
                            <option value="" disabled>Lokasi</option>
                            @foreach ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}">{{ $lokasi->ruangan }} {{ $lokasi->lantai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

<script>
    function showEditHostModal(hostId, nama, username, alamat, nomorTelepon, email, jenisKelamin, divisiId, lokasiId) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_nomor_telepon').value = nomorTelepon;
        document.getElementById('edit_email').value = email;
        
        if (jenisKelamin === 'Laki-laki') {
            document.getElementById('edit_jenis_kelamin_laki_laki').checked = true;
        } else {
            document.getElementById('edit_jenis_kelamin_perempuan').checked = true;
        }

        document.getElementById('edit_divisi').value = divisiId;
        document.getElementById('edit_lokasi').value = lokasiId;
        document.getElementById('editForm').action = `/host/${hostId}`;

        $('#editHostModal').modal('show');
    }
</script>

<script>
    function confirmDelete(event, id) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: 'Anda tidak akan dapat mengembalikan data ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'  // Mengubah teks tombol Cancel menjadi Batal
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi intlTelInput untuk input nomor telepon
        var editInput = document.querySelector("#edit_phone");
        var editIti = window.intlTelInput(editInput, {
            initialCountry: "auto", // Atur sesuai kebutuhan atau negara default
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        // Mendapatkan nomor telepon dari data yang sudah ada
        var existingNumber = "{{ $host->nomor_telepon }}"; // Pastikan Anda memiliki nilai ini dari backend atau menggunakan PHP

        // Set nomor telepon yang ada pada input
        editIti.setNumber(existingNumber);

        // Menangani perubahan negara
        editIti.addEventListener("countrychange", function() {
            var selectedCountryData = editIti.getSelectedCountryData();
            var countryCode = selectedCountryData.dialCode;
            var phoneNumber = editIti.getNumber().replace(/\D/g, '');
            if (!phoneNumber.startsWith(countryCode)) {
                phoneNumber = "+" + countryCode + phoneNumber;
                editIti.setNumber(phoneNumber);
            }
        });

        // Menangani submit form
        document.querySelector('#editForm').addEventListener('submit', function(event) {
            var phoneNumber = editIti.getNumber();
            editInput.value = phoneNumber;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.querySelectorAll(".fade-up");
        elements.forEach(function(element) {
            element.classList.add("visible");
        });

        // Fungsi pencarian
        document.querySelector('.search-btn').addEventListener('click', function() {
            var searchText = document.getElementById('searchInput').value.toUpperCase();
            var rows = document.querySelectorAll('#hostTableBody tr');

            rows.forEach(function(row) {
                var textContent = row.textContent.toUpperCase();
                if (textContent.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    var editInput = document.querySelector("#edit_phone");
    var editIti = window.intlTelInput(editInput, {
        initialCountry: "auto",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        hiddenInput: "edit_phone", // Untuk menyimpan nomor telepon dalam format tersembunyi jika diperlukan
    });

    // Set nomor telepon yang ada pada input
    var existingNumber = "{{ $host->nomor_telepon }}"; // Pastikan Anda memiliki nilai ini dari backend atau menggunakan PHP
    editIti.setNumber(existingNumber);

    // Menambahkan country selector
    var editCountrySelector = document.getElementById('edit_countrySelector');
    editCountrySelector.appendChild(editIti.countryList);

    // Menangani perubahan negara
    editIti.addEventListener("countrychange", function() {
        var selectedCountryData = editIti.getSelectedCountryData();
        var countryCode = selectedCountryData.dialCode;
        var phoneNumber = editIti.getNumber().replace(/\D/g, '');
        if (!phoneNumber.startsWith(countryCode)) {
            phoneNumber = "+" + countryCode + phoneNumber;
            editIti.setNumber(phoneNumber);
        }
    });

    // Menangani submit form
    document.querySelector('#editForm').addEventListener('submit', function(event) {
        var phoneNumber = editIti.getNumber();
        editInput.value = phoneNumber;
    });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        initialCountry: "auto",
        nationalMode: false,
        separateDialCode: true,
        geoIpLookup: function(callback) {
            fetch('https://ipinfo.io/json?token=<YOUR_TOKEN>')
                .then(response => response.json())
                .then(data => callback(data.country))
                .catch(() => callback('ID'));
        }
    });

    phoneInputField.addEventListener("countrychange", function() {
        const selectedCountryData = phoneInput.getSelectedCountryData();
        const countryCode = selectedCountryData.dialCode;
        let phoneNumber = phoneInput.getNumber().replace(/\D/g, '');
        if (!phoneNumber.startsWith(countryCode)) {
            phoneNumber = "+" + countryCode + phoneNumber;
            phoneInput.setNumber(phoneNumber);
        }
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        const phoneNumber = phoneInput.getNumber();
        phoneInputField.value = phoneNumber;
    });
});
</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');
    
        // Function to set the initial icon for password field
        function updatePasswordIcon(input, icon) {
            const type = input.getAttribute('type');
            if (type === 'password') {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    
        // Set the initial icon on page load for password field
        updatePasswordIcon(password, togglePassword);
    
        // Toggle the visibility of the password field
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            updatePasswordIcon(password, togglePassword);
        });
    
        // Set the initial icon on page load for password confirmation field
        updatePasswordIcon(passwordConfirmation, togglePasswordConfirmation);
    
        // Toggle the visibility of the password confirmation field
        togglePasswordConfirmation.addEventListener('click', function (e) {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            updatePasswordIcon(passwordConfirmation, togglePasswordConfirmation);
        });
    });
</script>

@endsection
