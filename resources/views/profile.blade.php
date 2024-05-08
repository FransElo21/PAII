@extends('layouts.app')

@section('content')
  <style>
    /* CSS untuk mengatur foto profile menjadi lingkaran */
    .profile-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
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
                <label for="namaLengkap"><b>Nama Lengkap:</b></label>
                <input type="text" class="form-control" id="namaLengkap" value="{{ Auth::user()->namaLengkap }}" readonly>
              </div>
              <!-- Username -->
              <div class="form-group">
                <label for="username"><b>Username:</b></label>
                <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" readonly>
              </div>
              <!-- Email -->
              <div class="form-group">
                <label for="email"><b>Email:</b></label>
                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
              </div>
            </div>
            <!-- Kolom Kanan -->
            <div class="col-md-6">
              <!-- Jenis Kelamin -->
              <div class="form-group">
                <label for="jenisKelamin"><b>Jenis Kelamin:</b></label>
                <input type="text" class="form-control" id="jenis_kelamin" value="{{ Auth::user()->jenis_kelamin }}" readonly>
              </div>
              <!-- Nomor Telepon -->
              <div class="form-group">
                <label for="nomorTelepon"><b>Nomor Telepon:</b></label>
                <input type="text" class="form-control" id="nomor_telepon" value="0{{ Auth::user()->nomor_telepon }}" readonly>
              </div>
              <!-- Alamat -->
              <div class="form-group">
                <label for="alamat"><b>Alamat:</b></label>
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
