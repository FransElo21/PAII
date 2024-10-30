@extends('layouts.app')

@section('content')
  <style>
    /* CSS untuk mengatur foto profile menjadi lingkaran dan memberikan shadow */
    .profile-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* CSS untuk card */
    .card {
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      border: none;
      background-color: #ffffff;
    }

    /* CSS untuk card header */
    .card-header {
      background-color: red;
      color: white;
      border-radius: 15px 15px 0 0;
      border: none;
    }

    /* CSS untuk card footer */
    .card-footer {
      border-top: none;
      background-color: #f8f9fa;
      border-radius: 0 0 15px 15px;
    }

    /* CSS untuk tombol */
    .btn-primary {
      border-radius: 20px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: red;
      border-color: red;
    }

    /* CSS untuk form control */
    .form-control {
      border-radius: 10px;
    }

    /* CSS untuk label */
    label {
      font-weight: bold;
    }

    /* CSS untuk container */
    .container {
      padding-top: 20px;
    }

    /* CSS untuk card body */
    .card-body {
      padding: 2rem;
    }

    /* CSS untuk form group */
    .form-group {
      margin-bottom: 1.5rem;
    }
  </style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(Session::has('update_berhasil'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Logout Berhasil!",
        });
    </script>
    @endif

    @if(session('upsuccess'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('upsuccess') }}',
        });
    </script>
    @endif

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center">
          <h2>Profile</h2>
        </div>
        <!-- Foto Profile -->
        <div class="text-center mt-4">
          <img src="{{ asset(Auth::user()->foto_profil) }}" alt="Foto Profil"  class="profile-img">
        </div>
        <div class="card-body">
          <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
              <!-- Nama Lengkap -->
              <div class="form-group">
                <label for="namaLengkap">Nama Lengkap:</label>
                <input type="text" class="form-control" id="namaLengkap" value="{{ Auth::user()->namaLengkap }}" readonly>
              </div>
              <!-- Username -->
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" readonly>
              </div>
              <!-- Email -->
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
              </div>
              <div class="form-group">
                <label for="email">Pekerjaan:</label>
                <input type="text" class="form-control" id="email" value="{{ Auth::user()->status_pekerjaan }}" readonly>
              </div>
            </div>
            <!-- Kolom Kanan -->
            <div class="col-md-6">
              <!-- Jenis Kelamin -->
              <div class="form-group">
                <label for="jenisKelamin">Jenis Kelamin:</label>
                <input type="text" class="form-control" id="jenis_kelamin" value="{{ Auth::user()->jenis_kelamin }}" readonly>
              </div>
              <!-- Nomor Telepon -->
              <div class="form-group">
                <label for="nomorTelepon">Nomor Telepon:</label>
                <input type="text" class="form-control" id="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}" readonly>
              </div>
              <!-- Alamat -->
              <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea class="form-control" id="alamat" rows="3" readonly>{{ Auth::user()->alamat }}</textarea>
              </div>
            </div>
          </div>
        </div>
        <!-- Tombol Edit Profile -->
        <div class="card-footer text-center">
          <a href="/profile/edit" class="btn btn-primary">Edit Profile</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
