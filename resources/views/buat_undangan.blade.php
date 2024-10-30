@extends('layouts.app')

@section('content')
<style>
    .card {
        border-radius: 30px;
        box-shadow: 0 10px 16px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border-radius: 20px;
        border-color: #ccc;
    }

    .form-group h4 {
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        border-radius: 20px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .card-header {
        color: white;
        font-size: 25px;
        border-radius: 25px;
        padding: 20px 0;
        text-align: center;
    }

    .group-member {
        margin-bottom: 10px;
    }
</style>

<div class="container mt-5">
    <form action="{{ route('janji_temu.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header" style="justify-content: center">
                <h2 class="card-title mb-2" style="font-size:27px;"><b>Kunjungan</b></h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <label class="me-3">
                            <input type="radio" name="keperluan" value="Pribadi" required>
                            Pribadi
                        </label>
                        <label>
                            <input type="radio" name="keperluan" value="Pekerjaan" required>
                            Pekerjaan
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="kunjungan_dari" name="kunjungan_dari" class="form-control" placeholder="Kunjungan Dari" required>
                    </div>
                    <div class="col-md-6">
                        <select name="host_id" id="host_id" class="form-control custom-dropdown" required>
                            <option value="" disabled selected>Orang yang akan dikunjungi :</option>
                            @foreach($hosts as $host)
                                <option value="{{ $host->id }}" data-nama="{{ $host->nama }}" data-divisi="{{ $host->divisi->nama_divisi }}" data-ruangan="{{ $host->lokasi->ruangan }} {{ $host->lokasi->lantai }}">
                                    {{ $host->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div id="host_details" style="display: none;">
                            <p>Orang yang akan dikunjungi :</p>
                            <p><strong>Nama:</strong> <span id="host_nama">Frans Panjaitan</span></p>
                            <p><strong>Divisi:</strong> <span id="host_divisi">Divisi</span></p>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="waktu_temu" class="form-label">Waktu Temu</label>
                        <input type="datetime-local" id="waktu_temu" name="waktu_temu" class="form-control" placeholder="Waktu Temu" required>
                    </div>
                    <div class="col-md-6">
                        <label for="waktu_kembali" class="form-label">Waktu Kembali</label>
                        <input type="datetime-local" id="waktu_kembali" name="waktu_kembali" class="form-control" placeholder="Waktu Kembali">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" required>
                    </div>
                    <div class="col-md-6">
                        <input type="number" id="num_visitors" name="num_visitors" class="form-control" min="0" placeholder="Tambahkan Pengunjung">
                    </div>
                </div>
                <div id="visitorFields"></div>
            </div>
            <div class="card-footer" style="text-align: center">
                <button type="submit" class="btn btn-success rounded-pill">Submit</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('buat_undangan_berhasil'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success Membuat Undangan!',
        text: '{{ session('buat_undangan_berhasil') }}',
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: '{!! implode('<br>', $errors->all()) !!}',
    });
</script>
@endif

<script>
    $(document).ready(function () {
        $('#num_visitors').on('input', function () {
            const numVisitors = $(this).val();
            const visitorFields = $('#visitorFields');
            visitorFields.empty();

            for (let i = 0; i < numVisitors; i++) {
                const visitorForm = `
                    <div class="row mb-3 visitor-group">
                        <div class="col-md-3">
                            <input type="text" name="visitors[${i}][name]" class="form-control" placeholder="Nama Pengunjung" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="visitors[${i}][email]" class="form-control" placeholder="Email Pengunjung" required>
                        </div>
                        <div class="col-md-3">
                            <input id="phone-${i}" class="form-control" type="tel" name="visitors[${i}][phone]" placeholder="Nomor Telepon Pengunjung" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="visitors[${i}][nik]" class="form-control" placeholder="NIK Pengunjung" required>
                        </div>
                    </div>`;
                visitorFields.append(visitorForm);

                // Inisialisasi intl-tel-input untuk setiap input telepon
                const phoneInputField = document.querySelector(`#phone-${i}`);
                const phoneInput = window.intlTelInput(phoneInputField, {
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                });

                phoneInputField.addEventListener("countrychange", function() {
                    phoneInputField.value = '';
                    const selectedCountryData = phoneInput.getSelectedCountryData();
                    const countryCode = selectedCountryData.dialCode;
                    let phoneNumber = phoneInput.getNumber();
                    phoneNumber = phoneNumber.replace(/\D/g, '');
                    if (!phoneNumber.startsWith(countryCode)) {
                        phoneNumber = "+" + countryCode + phoneNumber;
                        phoneInput.setNumber(phoneNumber);
                    }
                });
            }
        });

        $('#host_id').change(function () {
            var selectedOption = $(this).children("option:selected");
            var nama = selectedOption.data('nama');
            var divisi = selectedOption.data('divisi');
            var ruangan = selectedOption.data('ruangan');
            
            $('#host_nama').text(nama);
            $('#host_divisi').text(divisi);
            $('#host_ruangan').text(ruangan);
            $('#host_details').show();
        });

        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        now.setMinutes(now.getMinutes());
        var nowISO = now.toISOString().slice(0, 16);
        $('#waktu_temu').attr('min', nowISO);
        $('#waktu_kembali').attr('min', nowISO);

        // Fungsi untuk mengatur minimum waktu kembali berdasarkan waktu temu
$('#waktu_temu').change(function () {
    var waktuTemu = $(this).val();
    var waktuTemuDate = new Date(waktuTemu);
    var minWaktuKembali = new Date(waktuTemuDate.getTime() + 15 * 60000 + 420 * 60000).toISOString().slice(0, 16);

    $('#waktu_kembali').attr('min', minWaktuKembali);
    $('#waktu_kembali').val(minWaktuKembali);

    var selectedDateTime = new Date($(this).val()).getTime();
    var nowDateTime = new Date().getTime();

    if (selectedDateTime < nowDateTime) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Waktu tidak dapat dipilih sebelum waktu saat ini.',
        }).then(() => {
            $(this).val(nowISO);
            $('#waktu_kembali').attr('min', new Date(nowDateTime + 15 * 60000 + 420 * 60000).toISOString().slice(0, 16));
            $('#waktu_kembali').val(new Date(nowDateTime + 15 * 60000 + 420 * 60000).toISOString().slice(0, 16));
        });
    }
});

// Fungsi untuk validasi waktu kembali tidak kurang dari 15 menit setelah waktu temu
$('#waktu_kembali').change(function () {
    var waktuTemu = $('#waktu_temu').val();
    var waktuTemuDate = new Date(waktuTemu).getTime();
    var selectedDateTime = new Date($(this).val()).getTime();
    var minKembaliDateTime = new Date(waktuTemuDate + 15 * 60000 + 420 * 60000).getTime();

    if (selectedDateTime < minKembaliDateTime) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Waktu kembali harus setidaknya 15 menit setelah waktu temu.',
        }).then(() => {
            $(this).val(new Date(minKembaliDateTime).toISOString().slice(0, 16));
        });
    }
});


    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
@endsection
