@extends('entry_point.layouts.main')

@section('content')
<title>Scan QR Code</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card h-100 shadow">
                <div class="card-header text-center">
                    <h1 class="card-title">Scan QR Code</h1>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div id="reader" style="width: 100%;"></div>
                    <input type="text" id="result" class="form-control mt-3" readonly hidden>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="qrDetailCard" style="display: none;">
            <div class="card h-100 shadow">
                <div class="card-header text-center">
                    <h3 id="qrDetailTitle" class="card-title w-100 text-center">Detail QR Code</h3>
                </div>
                <div class="card-body d-flex">
                    <div class="profile-img-wrapper me-3">
                        <a id="fotoProfilLink" href="" target="_blank">
                            <img id="qrFotoProfil" src="" alt="Foto Profil" class="img-thumbnail border" style="width: 200px; height: 200px;">
                        </a>
                    </div>
                    <div class="flex-grow-1">
                        <div class="container mt-4 custom-detail">
                            <div class="row mb-3">
                                <div class="col-5"><strong>Nama Lengkap</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrNama"></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5"><strong>Host</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrHost"></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5"><strong>Waktu Temu</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrWaktuTemu"></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5"><strong>Waktu Kembali</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrWaktuKembali"></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5"><strong>Lokasi</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrLokasi"></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5"><strong>Check-in</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrCheckIn"></span></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5"><strong>Check-out</strong></div>
                                <div class="col-1">:</div>
                                <div class="col-6"><span id="qrCheckOut"></span></div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button id="rejectBtn" class="btn btn-danger">Tolak</button>
                                <button id="acceptBtn" class="btn btn-success">Terima</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>

<script>
    function formatTime(datetime) {
        if (!datetime) return '-';
        const date = new Date(datetime);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
    }

    let previousQrCode = null;

    function onScanSuccess(decodedText, decodedResult) {
        console.log("Decoded Text: ", decodedText);
        if (decodedText !== previousQrCode) {
            $('#result').val(decodedText);

            try {
                const qrData = JSON.parse(decodedText);
                console.log("QR Data: ", qrData);

                $('#qrNama').text(qrData.Nama);
                $('#qrHost').text(qrData.Host);
                $('#qrWaktuTemu').text(qrData['Waktu Temu']);
                $('#qrWaktuKembali').text(qrData['Waktu Kembali']);
                $('#qrLokasi').text(qrData.Lokasi);

                const fotoProfilUrl = qrData['Foto Profil']; // Absolute URL
                console.log("Foto Profil URL: ", fotoProfilUrl);

                // Set image source and link URL
                $('#qrFotoProfil').attr('src', fotoProfilUrl);
                $('#fotoProfilLink').attr('href', fotoProfilUrl);

                // Update card title based on check-in status from the backend response
                $.ajax({
                    url: '/check_qr_status',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        qr_code: decodedText
                    },
                    success: function (response) {
                        console.log(response);

                        const cardTitle = response.data.check_in ? "Check-out Visitor" : "Check-in Visitor";
                        $('#qrDetailTitle').text(cardTitle);

                        // Update check-in and check-out details
                        $('#qrCheckIn').text(formatTime(response.data.check_in));
                        $('#qrCheckOut').text(formatTime(response.data.check_out));

                        $('#qrDetailCard').show();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error checking QR code status: ", error);
                        $('#qrDetailCard').hide();
                    }
                });

                previousQrCode = decodedText;
            } catch (error) {
                console.error("QR code data is not in the expected format:", error);
                return;
            }
        }
    }

    function onScanFailure(error) {
        console.warn(`QR error = ${error}`);
    }

    $(document).ready(function() {
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 30, qrbox: { width: 250, height: 250 } },
            false
        );

        function resetScanner() {
            html5QrcodeScanner.clear().then(() => {
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }).catch(error => {
                console.error('Failed to reset QR scanner: ', error);
            });
        }

        function clearQrDetails() {
            $('#result').val('');
            $('#qrNama').text('');
            $('#qrHost').text('');
            $('#qrWaktuTemu').text('');
            $('#qrWaktuKembali').text('');
            $('#qrLokasi').text('');
            $('#qrFotoProfil').attr('src', '');
            $('#fotoProfilLink').attr('href', '');
            $('#qrCheckIn').text('');
            $('#qrCheckOut').text('');
            $('#qrDetailCard').hide();
            previousQrCode = null;
        }

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        $('#acceptBtn').on('click', function() {
            const qrCode = $('#result').val();
            $.ajax({
                url: '/scan_qr_code',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    qr_code: qrCode
                },
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        icon: response.status === 200 ? 'success' : 'error',
                        title: response.message,
                        confirmButtonText: 'Oke',
                        confirmButtonColor: "#0265F3"
                    }).then(() => {
                        clearQrDetails();
                        resetScanner();
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Silakan coba lagi nanti.',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: "#0265F3"
                    }).then(() => {
                        clearQrDetails();
                        resetScanner();
                    });
                }
            });
        });

        $('#rejectBtn').on('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Pemindaian QR code ditolak',
                confirmButtonText: 'Oke',
                confirmButtonColor: "#0265F3"
            }).then(() => {
                clearQrDetails();
                resetScanner();
            });
        });
    });
</script>
@endsection
