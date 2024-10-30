@extends('admin.layouts.main')

@section('content')

@if(session('custom_success'))
    <div class="alert alert-success">
        {{ session('custom_success') }}
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

<style>
    .btn-custom-blue {
        background-color: #007bff; /* Warna biru */
        color: white;
        border: none;
    }

    .btn-custom-blue:hover {
        background-color: #0056b3; /* Warna biru lebih gelap untuk efek hover */
    }

    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        margin-bottom: 20px;
    }

    .profile-details {
        width: 100%;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .card-header {
        background-color: #355283;
        color: white;
        font-size: 20px;
        text-align: center;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-control-plaintext {
        text-align: center;
        color: #333;
        font-weight: bold;
        font-size: 16px;
    }

    .button-group {
        display: flex;
        width: 100%;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn-xl {
        padding: 10px 20px;
        font-size: 16px;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        padding-right: 40px; /* Memberi ruang untuk ikon mata */
    }

    .password-wrapper .bi {
        position: absolute;
        top: 50%;
        right: 15px; /* Ubah nilai ini untuk memindahkan ikon mata ke kiri atau kanan */
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">{{ __('Admin Profile') }}</div>
                <div class="card-body">
                    <div class="profile-container">
                        <img src="{{ asset('images/profile/pic1.jpg') }}" class="rounded-circle profile-image" alt="Profile Picture">
                        <div class="profile-details">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control-plaintext" name="name" value="{{ $admin->Nama }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control-plaintext" name="username" value="{{ $admin->username }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button-group">
                        <a href="#" class="btn btn-custom-blue btn-xl" data-bs-toggle="modal" data-bs-target="#modalChangePassword">Ganti Password</a>
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-xl">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Change Password -->
<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="modalChangePasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalChangePasswordLabel"><b>Ganti Password</b></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.update_password') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row password-wrapper">
                        <label for="current_password" class="col-md-4 col-form-label text-md-right">Password Sekarang</label>
                        <div class="col-md-6">
                            <input id="current_password" type="password" class="form-control" name="current_password" required>
                            <i class="bi bi-eye" id="toggleCurrentPassword"></i>
                        </div>
                    </div>
                    <div class="form-group row password-wrapper">
                        <label for="new_password" class="col-md-4 col-form-label text-md-right">Password Baru</label>
                        <div class="col-md-6">
                            <input id="new_password" type="password" class="form-control" name="new_password" required>
                            <i class="bi bi-eye" id="toggleNewPassword"></i>
                        </div>
                    </div>
                    <div class="form-group row password-wrapper">
                        <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Konfirmasi Password Baru</label>
                        <div class="col-md-6">
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                            <i class="bi bi-eye" id="toggleConfirmPassword"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to set the initial icon
    function updatePasswordIcon(inputId, toggleId) {
        const togglePassword = document.querySelector(`#${toggleId}`);
        const password = document.querySelector(`#${inputId}`);
        if (password.getAttribute('type') === 'password') {
            togglePassword.classList.remove('bi-eye');
            togglePassword.classList.add('bi-eye-slash');
        } else {
            togglePassword.classList.remove('bi-eye-slash');
            togglePassword.classList.add('bi-eye');
        }
    }

    // Set initial icons
    updatePasswordIcon('current_password', 'toggleCurrentPassword');
    updatePasswordIcon('new_password', 'toggleNewPassword');
    updatePasswordIcon('new_password_confirmation', 'toggleConfirmPassword');

    function togglePasswordVisibility(toggleId, inputId) {
        const togglePassword = document.querySelector(`#${toggleId}`);
        const password = document.querySelector(`#${inputId}`);
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            updatePasswordIcon(inputId, toggleId);
        });
    }

    // Add event listeners for toggling passwords
    togglePasswordVisibility('toggleCurrentPassword', 'current_password');
    togglePasswordVisibility('toggleNewPassword', 'new_password');
    togglePasswordVisibility('toggleConfirmPassword', 'new_password_confirmation');
});
</script>

@endsection
