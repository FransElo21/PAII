
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambahkan Lokasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        /* CSS untuk menengahkan card */
        .card {
            margin: 0 auto; /* Membuat card menjadi di tengah */
            float: none; /* Membersihkan sisi kiri dan kanan */
            margin-bottom: 10px; /* Memberikan jarak antara card */
            border-radius: 30px; /* Tambahkan radius sudut pada card */
        }
        .container {
            justify-content: center;
            align-items: center;
            height: 100vh; /* Set tinggi container agar card berada di tengah vertikal */
        }
        body {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23c9121c" fill-opacity="1" d="M0,32L48,58.7C96,85,192,139,288,160C384,181,480,171,576,176C672,181,768,203,864,213.3C960,224,1056,224,1152,218.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');

            background-size: cover;
        }
        /* Tambahkan gaya untuk input */
        input[type=text], input[type=submit] {
            border-radius: 30px; /* Tambahkan radius sudut */
            padding: 10px; /* Tambahkan ruang di dalam input */
        }
        /* Tambahkan gaya untuk card header */
        .card-header {
            text-align: center; /* Menengahkan teks */
            background-color: white;

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
      background-color: #40A752;
    }

    .btn-login-batal {
      background-color: #FF0000;

    }

    .btn-login:hover {
      background-color: #05b94d;
    }

    .btn-login-batal:hover {
      background-color: #FF3333; 
    }
    </style>
</head>


<body>
    <div class="container" style="align-content: center">
        <div class="row justify-content-center">
            <div class="col-md-6" data-aos="fade-up">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="card-header">
                            <h3>Tambah Lokasi</h3>
                        </div>
                        <form action="{{ route('lokasi.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="ruangan">Lantai:</label>
                                <input type="text" class="form-control" id="ruangan" name="ruangan" required>
                            </div>
                            <div class="form-group">
                                <label for="lantai">Ruangan:</label>
                                <input type="text" class="form-control" id="lantai" name="lantai" required  >
                            </div>
                            <div style="display: flex; justify-content: space-between;"> 
                                <button type="button" class="btn btn-danger btn-login btn-login-batal ml-2" onclick="window.location.href='/lokasi_admin'">Kembali</button> 
                                <button type="submit" class="btn btn-primary btn-login btn-login-kirim">Tambah</button>               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
