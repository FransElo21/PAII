<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/jpeg" href="image/Flogin.jpg">
<title>Login</title>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
  .Login {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23B0DCE9" fill-opacity="1" d="M0,32L48,58.7C96,85,192,139,288,160C384,181,480,171,576,176C672,181,768,203,864,213.3C960,224,1056,224,1152,218.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
    background-size: cover;
    position: relative;
    height: 100vh;
    padding: 20px;
    overflow: hidden;
  }
  .card-custom {
    background-color: white;
    border-radius: 20px;
    padding: 20px;
    max-width: 550px; /* Perkecil ukuran card */
    margin: 0 auto; /* Tengahkan card */
  }
  .form-group {
    position: relative;
  }
  input[type="text"],
  input[type="password"] {
    border: 1px solid #ced4da;
    border-radius: 20px;
    padding: 12px; /* Perkecil padding */
    padding-left: 40px; /* Sesuaikan padding kiri dengan gambar */
  }
  .bi-person-fill, .bi-lock-fill {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: black;
  }
  .Eye, .User {
    width: 28px;
    height: 32px;
    position: absolute;
    top: 50%;
    left: 12px; /* Atur posisi gambar */
    transform: translateY(-50%);
  }
  .LupaKataSandi {
    color: #0000FF;
    font-size: 14px; /* Perkecil ukuran font */
  }
  .BelumPunyaAkunRegistrasi {
    font-size: 14px; /* Perkecil ukuran font */
  }
  .btn-login {
    width: fit-content;
    padding-inline: 2rem;
    font-size: 16px; /* Perbesar ukuran font */
    background-color: #06DD59;
    border: none;
    border-radius: 20px;
    transition: background-color 0.3s ease;
  }
  .btn-login:hover {
    background-color: #05b94d;
  }
  .fade-up {
    animation: fadeInUp 1s ease-in-out;
  }
  .fade-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s, transform 0.5s;
  }

  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

  .label {
    text-align: left;
  }

  .lupa {
    text-align: right;
  }

  .Aerror {
    text-align: left;
  }
</style>
</head>
<body>

<div class="container-fluid Login">
  
  <div class="row justify-content-center fade-up">
    <div class="col-md-6">
      <div class="card card-custom mt-5">
        <div class="card-body text-center">
          <img src="images/Flogin.jpg" alt="Logo" style="width: 200px; height: auto;"> <!-- Perkecil ukuran gambar -->
          <h4 class="mt-3 mb-3">Visitor Management System</h4>

          <form method="POST" action="{{ route('login') }}">
          @csrf
            <div class="label"><label for="username">Username</label></div>  
            <div class="form-group">
              <i class="bi bi-person-fill"></i>
              <input type="text" class="form-control" id="username" name="username" value="" placeholder="Username" required>
            </div>
            @if($errors->has('username'))
              <li class="Aerror">{{ $errors->first('username') }}</li>
            @endif

            <div class="label"><label for="password">Password</label></div>
            <div class="form-group">
              <i class="bi bi-lock-fill"></i>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            @if($errors->has('password'))
              <li class="Aerror">{{ $errors->first('password') }}</li>
              <!-- <li class="alert alert-danger">{{ $errors->first('password') }}</li> -->
            @endif
            
            
            <div class="mt-1 lupa">
              <a href="#" class="LupaKataSandi">Lupa Password?</a>
            </div>
            <div style="display: flex; justify-content:center;">
                <button type="submit" class="btn btn-primary btn-block btn-login">Masuk</button>
            </div>
          </form>
          
          <div class="mt-3">
            <span>Belum memiliki akun? </span><a href="registrasi" class="BelumPunyaAkunRegistrasi">Daftar Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fadeUpElements = document.querySelectorAll('.fade-up');
        fadeUpElements.forEach(function (element) {
            element.classList.add('visible');
        });
    });
</script>

</div>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(Session::has('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Logout Berhasil!",
        });
    </script>
    @endif


    @if(session('registrasi_berhasil'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Registrasi Berhasil!",
        });
    </script>
    @endif

    @if(session('login_gagal'))
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Username atau Password tidak valid!, Silahkan login ulang",
        });
    </script>
    @endif

</body>
</html>
