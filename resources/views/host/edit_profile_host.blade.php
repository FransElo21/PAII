<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/jpeg" href="image/Flogin.jpg">
  <title>Edit profile</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <style>
    body {
      background-color: #f9f9f9;
    }

    .Login {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23B0DCE9" fill-opacity="1" d="M0,32L48,58.7C96,85,192,139,288,160C384,181,480,171,576,176C672,181,768,203,864,213.3C960,224,1056,224,1152,218.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
      background-size: cover;
    }

    .card-custom {
      background-color: white;
      border-radius: 30px;
      box-shadow: -80px 0px 30px rgba(0, 200, 200, 0.8); /* Mengatur lebar bayangan pada sisi kiri */
      padding: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"],
    select,
    textarea {
      border: 1px solid #ced4da;
      border-radius: 25px;
      padding: 15px;
    }

    .radio-group{
      margin-left: 25px;
    }
    
    select.form-control {
       border-radius: 25px;
    }
    input[type="email"].form-control,
    input[type="password"].form-control {
      border-radius: 25px;
    }
    textarea.form-control {
       border-radius: 25px;
    }

    .bi-person-fill,
    .bi-lock-fill {
      position: absolute;
      top: 50%;
      left: 20px;
      transform: translateY(-50%);
      color: #6c757d;
    }

    .btn-login {
      width: fit-content;
      justify-content: center;
      padding-inline: 2rem;
      font-size: 20px;
      border: none;
      border-radius: 30px;
      transition: background-color 0.3s ease;
    }

    .btn-login-kirim {
      background-color: #06DD59;
    }

    .btn-login-batal {
      background-color: #FF0000;
      margin-right: 10px;
    }

    .btn-login:hover {
      background-color: #05b94d;
    }

    .btn-login-batal:hover {
      background-color: #FF3333; /* Ubah warna hover */
    }

    .mt-3 {
      margin-top: 15px;
    }

    .LupaKataSandi,
    .BelumPunyaAkunRegistrasi {
      color: #0000FF;
      font-size: 15px;
    }

    .BelumPunyaAkunRegistrasi {
      font-size: 15px;
    }

    .fade-up {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.5s, transform 0.5s, box-shadow 0.5s;
    }

    .fade-up.visible {
      opacity: 1;
      transform: translateY(0);
      box-shadow: none; /* Menghapus bayangan saat card muncul */
    }

    .text-center {
      text-align: center;
    }

    /* Atur ukuran tombol untuk layar berukuran kecil */
    @media (max-width: 576px) {
      .btn-login {
        width: 100%;
        margin-top: 10px;
      }
    }

    /* Custom styling for the form */
    .form-custom {
      max-width: 600px; /* Adjust based on your preference */
      margin: auto;
    }

    .form-custom .form-group {
      margin-bottom: 20px;
    }

    .form-custom label {
      font-weight: bold;
    }

    .form-custom input[type="file"] {
      margin-top: 10px;
    }

    #currentProfilePicture {
      max-width: 200px;
      border-radius: 50%; /* Membuat gambar menjadi lingkaran */
      border: 3px solid #fff; /* Menambahkan border putih untuk memberikan efek highlight */
    }
  </style>

</head>
<body>

<div class="Login">
  <div class="container">
    <div class="row justify-content-center fade-up">
      <div class="col-md-6">
        <div class="card card-custom">
          <div class="card-body">
            <form class="form-custom" method="POST" action="{{ route('profile_host.update') }}" enctype="multipart/form-data">
              @csrf
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <img id="currentProfilePicture" src="{{ asset(Auth::guard('host')->user()->foto_profil) }}" alt="Foto Profil Saat Ini" style="max-width: 200px;">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="foto_profil">Unggah Foto Profil Baru:</label>
                  <input type="file" class="form-control-file" id="foto_profil" name="foto_profil" accept="image/*">
                </div>
              </div>      
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                      <label for="nama">Nama Lengkap:</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">
                    </div>
                    <div class="form-group">
                      <label for="username">Username:</label>
                      <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                    </div>
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                      <label for="jenis_kelamin">Jenis Kelamin:</label>
                      <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="{{ $user->jenis_kelamin }}">
                    </div>
                    <div class="form-group">
                      <label for="nomor_telepon">Nomor Telepon:</label>
                      <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="{{ $user->nomor_telepon }}">
                    </div>
                    <div class="form-group">
                      <label for="alamat">Alamat:</label>
                      <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $user->alamat }}</textarea>
                    </div>
                </div>
            </div>    
              <button type="submit" class="btn btn-primary btn-login btn-login-kirim">Update</button> 
              <a href="{{ route('profile_host') }}" class="btn btn-danger btn-login btn-login-batal">Kembali</a>   
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(Session::has('success'))
  <script>
    alert("{{ Session::get('success') }}");
  </script>
@endif
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const fadeUpElements = document.querySelectorAll('.fade-up');
    fadeUpElements.forEach(function (element) {
      element.classList.add('visible');
    });
  });
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    function handleScroll() {
      fadeUpElements.forEach(function (element) {
        if (isInViewport(element)) {
          element.classList.add('visible');
        }
      });
    }

    // Get all elements with the class 'fade-up'
    const fadeUpElements = document.querySelectorAll('.fade-up');

    // Function to check if an element is in the viewport
    function isInViewport(element) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }

    // Initial check on page load
    handleScroll();

    // Event listener for scroll
    window.addEventListener('scroll', handleScroll);
  });
</script>

<!-- Tambahkan SweetAlert ke halaman Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Kemudian, di bagian JavaScript Anda -->
<script>
  // Tambahkan event listener untuk tombol "Batal"
  document.addEventListener('DOMContentLoaded', function () {
    const cancelButton = document.querySelector('.btn-login-batal');
    cancelButton.addEventListener('click', function (event) {
      event.preventDefault(); // Mencegah aksi default dari tombol "Batal"

      // Tampilkan SweetAlert untuk mengkonfirmasi pembatalan
      Swal.fire({
        title: 'Apakah Anda ingin Kembali?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Kembali!',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        // Jika pengguna menekan tombol "Ya"
        if (result.isConfirmed) {
          // Redirect ke halaman tertentu
          window.location.href = '/profile';
        }
      });
    });
  });
</script>

<script>
  // Mengubah teks label sesuai nama file yang dipilih
  document.getElementById('foto_profil').addEventListener('change', function() {
    var fileName = this.files[0].name;
    var nextSibling = this.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>

</body>
</html>
