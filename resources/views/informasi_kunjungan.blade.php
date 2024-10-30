@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-size: 25px; color:black;">Informasi Kunjungan</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <h5 class="card-title">Informasi Penting</h5>
                                <p class="card-text">Terima kasih telah mengunjungi kami! Berikut adalah informasi penting untuk kunjungan Anda:</p> --}}
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" style="padding: 5px 0;"><b>Jam Operasional Kunjungan</b>
                                        <p style="margin: 5px 0;">08.00 - 17.00</p>
                                    </li>
                                    <li class="list-group-item" style="padding: 5px 0;"><b>Hari Operasional Kunjungan</b>
                                        <p style="margin: 5px 0;">Senin - Jumat</p>
                                    </li>
                                    <li class="list-group-item" style="padding: 5px 0;"><b>Informasi Kunjungan</b>
                                        <p style="margin: 5px 0;">10 Lantai</p>
                                    </li>
                                    <li class="list-group-item" style="padding: 5px 0;"><b>Alamat</b>
                                        <p style="margin: 5px 0;">Depan gerbang Institut Teknologi Del, Sitoluama, Kec. Balige, Toba, Sumatera Utara 22381</p>
                                    </li>
                                    <li class="list-group-item" style="padding: 5px 0;"><b>catatan</b>
                                        <p style="margin: 5px 0;">Dapat bertanya pada resepsionis atau satpam jika mengalami kesulitan</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title"></h5>
                                <!-- Google Map Embed -->
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.363795030467!2d99.14575207447052!3d2.384441107378345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e00fdad2d7341%3A0xf59ef99c591fe451!2sInstitut%20Teknologi%20Del!5e0!3m2!1sid!2sid!4v1716747453662!5m2!1sid!2sid"
                                    width="100%"  
                                    height="300" 
                                    frameborder="0" 
                                    style="border:0; margin-top: 10px;" 
                                    allowfullscreen="" 
                                    aria-hidden="false" 
                                    tabindex="0">
                                </iframe>
                                <a href="https://www.google.com/maps" class="btn btn-primary mt-3">Lihat Peta</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <!-- Additional footer content can go here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card {
            border-radius: 30px;
        }
    
        .list-group-item {
            background-color: #f8f9fa;
            border: none;
            border-bottom: 1px solid #dee2e6;
        }
    
        .list-group-item:last-child {
            border-bottom: none;
        }
    
        .card-header {
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
        }
    
        .embed-responsive-16by9 {
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            position: relative;
        }
    
        .embed-responsive-16by9 iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
