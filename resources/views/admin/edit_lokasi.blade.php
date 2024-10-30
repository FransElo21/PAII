<!DOCTYPE html>
<html>
<head>
    <title>Edit Lokasi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f9f9f9;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23c9121c" fill-opacity="1" d="M0,32L48,58.7C96,85,192,139,288,160C384,181,480,171,576,176C672,181,768,203,864,213.3C960,224,1056,224,1152,218.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');

            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid #ddd;
            border-radius: 50px;
            width: 600px;
            padding: 20px;
            background-color: white;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }
        .form-control {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
        .card-header {
            text-align: center;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .btn {
            padding: 10px 15px; /* Increase padding */
            font-size: 20px; /* Increase font size */
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            border-radius: 30px;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-danger {
            border-radius: 30px;
        }
        .btn-danger:hover {
            background-color: #d31616;
            border-color: #d31616;
        }
    </style>
</head>
<body>
    
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

<div class="col-lg-12 d-flex justify-content-center">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Lokasi</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('update_lokasi', $lokasis->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="ruangan">Lantai:</label>
                    <input type="text" class="form-control" id="ruangan" name="ruangan" value="{{ $lokasis->ruangan }}">
                </div>
                <div class="form-group">
                    <label for="lantai">Ruangan:</label>
                    <input type="text" class="form-control" id="lantai" name="lantai" value="{{ $lokasis->lantai }}">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('lokasi.show') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
