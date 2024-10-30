<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Undangan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Kunjungan Dari</th>
                <th>Host</th>
                <th>Subjek</th>
                <th>Waktu Bertemu</th>
                <th>Waktu Kembali</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1 @endphp
            @foreach ($undanganDiterima as $item)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $item->pengunjung->namaLengkap }}</td>
                <td>{{ $item->kunjungan_dari }}</td>
                <td>{{ $item->host->nama }}</td>
                <td>{{ $item->subject }}</td>
                <td>{{ $item->waktu_temu }}</td>
                <td>{{ $item->waktu_kembali }}</td>
                <td>{{ $item->lokasi->ruangan }} {{ $item->lokasi->lantai }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
