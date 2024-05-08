<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/jpeg" href="image/Flogin.jpg">
  <title>Tambah Host</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-color: #f9f9f9;
      background: linear-gradient(120deg, #B0DCE9, #FFFFFF); /* Mengatur gradasi warna latar belakang */
      height: 100%;
      overflow: hidden;
    }

    .Login {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: auto; /* Mengatur overflow agar konten dapat di-scroll jika melebihi ketinggian layar */
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
      background-color: #06DD59;
      border: none;
      border-radius: 30px;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: #05b94d;
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

    /* CSS untuk radio button horizontal */
    .radio-group {
      display: flex;
      justify-content: space-between;
    }

    .radio-item {
      flex: 1;
      margin-right: 10px;
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
            <h3 class="text-center mt-3 mb-3">Tambah Host</h3>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('Tambah_host.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="form-group position-relative">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
              </div>

              <div class="form-group position-relative">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
              </div>

              <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              </div>

              <div class="form-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
              </div>

              <div class="form-group">
                <div class="radio-group">
                  <div class="radio-item">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" required>
                    <label class="form-check-label" for="laki-laki">
                      <i class="bi bi-gender-male"></i> Laki-laki
                    </label>
                  </div>
                  <div class="radio-item">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                    <label class="form-check-label" for="perempuan">
                      <i class="bi bi-gender-female"></i> Perempuan
                    </label>
                  </div>
                </div>
              </div> 
                           
              <div class="form-group">
                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" placeholder="Nomor Telepon" required>
              </div>
                            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
              </div>

              <div class="form-group">
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
              </div>
              
              <select class="form-control form-group" id="divisi" name="divisi_id">
                <option value="" disabled selected>Pilih Divisi</option> <!-- Placeholder -->
                @foreach ($divisis as $divisi)
                  <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                @endforeach
              </select>     
              
              <select class="form-control form-group" id="lokasi" name="lokasi_id">
                <option value="" disabled selected>Pilih Lokasi</option> <!-- Placeholder -->
                @foreach ($lokasis as $lokasi)
                  <option value="{{ $lokasi->id }}">{{ $lokasi->ruangan }}</option>
                @endforeach
              </select>  
          
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto_profil" name="foto_profil" accept="image/*">
                  <label class="custom-file-label" for="foto_profil">Pilih Foto Profile</label>
                </div>
              </div>              

              <div style="display: flex; justify-content:center;">
                <button type="submit" class="btn btn-primary">Tambah</button>
              </div>
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

<script>
  // Mengubah teks label sesuai nama file yang dipilih
  document.getElementById('foto_profil').addEventListener('change', function() {
    var fileName = this.files[0].name;
    var nextSibling = this.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(Session::has('success'))
  <script>
    Swal.fire({
      icon: "success",
      title: "Login Berhasil!",
    });
  </script>
@endif

</body>
</html>
