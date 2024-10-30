<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/jpeg" href="image/Flogin.jpg">
<title>Konfirmasi Undangan</title>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
  body {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ff0800" fill-opacity="1" d="M0,32L48,58.7C96,85,192,139,288,160C384,181,480,171,576,176C672,181,768,203,864,213.3C960,224,1056,224,1152,218.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
    position: relative;
    height: 100vh;
    padding: 20px;
    overflow: hidden;
    background-size: cover;
  }
  .card-custom {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 20px;
    max-width: 750px;
    margin: 0 auto;
    margin-top: 50px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
  }
  .card-header {
    color: black;
    padding: 15px;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    background-color: white;
  }
  .card-title {
    margin-bottom: 0;
    font-size: 24px;
  }
  .card-body {
    padding-top: 30px;
  }
  p {
    margin-bottom: 5px;
    color: #555;
  }
  .value {
    font-weight: bold;
    font-size: 16px;
    color: #333;
  }
  .note-field {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    height: 110px;
  }
  .btn-accept {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    margin-right: 10px;
  }
  .btn-reject {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
  }
  .note-field {
    border-radius: 20px;
  }
</style>
</head>
<body>

<div class="container">
  <div class="card card-custom animate__animated animate__fadeInUp">
    <form action="{{ route('accept.undangan', ['undangan_id' => $undangan->id]) }}" method="POST">
      @csrf
      <div class="card-header">
        <h2 class="card-title">Informasi Kunjungan</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p>Subject:</p>
            <div class="value">{{ $undangan->subject }}</div>

            <p>Nama Pengunjung:</p>
            <div class="value">{{ $undangan->Pengunjung->namaLengkap }}</div>

            <p>Kunjungan dari:</p>
            <div class="value">{{ $undangan->kunjungan_dari }}</div>

            <p>Nomor Telepon:</p>
            <div class="value">{{ $undangan->Pengunjung->nomor_telepon }}</div>
          </div>
          <div class="col-md-6">
            <p>Waktu Kedatangan:</p>
            <div class="value">{{ \Carbon\Carbon::parse($undangan->waktu_temu)->format('d/m/Y H:i') }}</div>

            <p>Waktu Kepulangan:</p>
            <div class="value">{{ \Carbon\Carbon::parse($undangan->waktu_kembali)->format('d/m/Y H:i') }}</div>

            <p>Keperluan Kunjungan:</p>
            <div class="value">{{ $undangan->keperluan }}</div>

            <p>Jenis Kunjungan:</p>
            <div class="value">{{ $undangan->type }}</div>

            <p>Jumlah Pengunjung:</p>
            <div class="d-flex align-items-center">
              <span class="value">{{ $nrVisitor }}</span>
              <button type="button" class="btn btn-primary btn-xs sharp me-1 ml-3" onclick="showVisitorDetails({{ $undangan->id }})">
                Detail
              </button>
            </div>
          </div>
        </div>
        <p>Note:</p>
        <div class="note-field" readonly>{{ $undangan->keterangan }}</div>
        <div class="text-end mt-4" style="display: flex; justify-content: flex-end;">
          <button type="submit" class="btn-accept" style="border-radius: 20px;">Terima</button>
          <button type="button" style="border-radius: 20px;" class="btn btn-danger btn-reject ml-2" onclick="window.location.href='{{ route('index_penolakan.show', ['id' => $undangan->id]) }}'">Tolak</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="visitorDetailsModal" tabindex="-1" aria-labelledby="visitorDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="visitorDetailsModalLabel">Detail Pengunjung Lainnya</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="visitorDetailsBody">
        <!-- Tempat untuk menampilkan detail pengunjung lainnya -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
  // Fungsi untuk menampilkan detail pengunjung lainnya di dalam modal
  function showVisitorDetails(undanganId) {
    // Ambil detail pengunjung lainnya sesuai dengan undanganId menggunakan AJAX
    // Di sini saya hanya menampilkan pesan sederhana sebagai contoh
    const visitorDetails = `
      <h5>Pengunjung Lainnya:</h5>
      @foreach($groupMembers as $member)
            <p>Nama: {{ $member['name'] }}</p>
            <p>Email: {{ $member['email'] }}</p>
            <p>Nomor Telepon: {{ $member['phone'] }}</p>
            <p>NIK: {{ $member['nik'] }}</p>
        @endforeach
    `;

    // Masukkan detail pengunjung lainnya ke dalam modal
    document.getElementById('visitorDetailsBody').innerHTML = visitorDetails;

    // Tampilkan modal
    $('#visitorDetailsModal').modal('show');
  }
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
