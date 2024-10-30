<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            border-radius: 20px;
            width: 600px;
            opacity: 0; /* At start, make it invisible */
            transform: translateY(20px); /* Start slightly below its normal position */
            animation: fadeUp 0.5s forwards; /* Animation for fade-up effect */
            background-color: white; /* Card background color */
            margin-top: 20px; /* Margin from top */
        }
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .form-control {
            margin-bottom: 10px;
            border-radius: 10px;
        }
        .btn {
            border-radius: 20px;
        }
        .card-header {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            background-color: #355283;
            font-size: 20px;
            color: white;
            text-align: center;
            padding: 15px; /* Padding for card header */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="">
                <div class="card shadow fade-up">
                    <div class="card-header" style="border-radius:5px;">Ganti Password</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('Entrypoint.update_password') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="current_password" class="col-md-4 col-form-label text-md-right">Password Sekarang</label>
                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control" name="current_password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 col-form-label text-md-right">Password Baru</label>
                                <div class="col-md-6">
                                    <input id="new_password" type="password" class="form-control" name="new_password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right"> Konfirmasi Password</label>
                                <div class="col-md-6">
                                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group row mt-4 mb-0 d-flex justify-content-between">
                                <div class="col-md-6 text-md-left">
                                    <a href="{{ route('profile_entry.show') }}" class="btn btn-danger btn-lg">Kembali</a>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                                </div>
                            </div>                            
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
