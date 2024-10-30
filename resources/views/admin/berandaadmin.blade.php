@extends('admin.layouts.main')

@section('content')
<style>
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 1s ease-out, transform 1s ease-out;
    }

    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="row justify-content-center fade-up">
    <div class="col-md-4">
        <div class="card text-center mb-4" style="height: 240px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 60px; color: #0D568B;">
                    {{ \App\Models\Host::count() }}
                </div>                    
                <p class="card-text mt-3" style="font-size: 20px;">Host</p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#hostModal">Daftar Host</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center mb-4" style="height: 240px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 60px; color: #0D568B;">
                    {{ \App\Models\Divisi::count() }}
                </div>   
                <p class="card-text mt-3" style="font-size: 20px;">Divisi</p>
                <a href="admin_divisi" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#divisiModal">Daftar Divisi</a>
            </div> 
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center mb-4" style="height: 240px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <div class="card-content display-4 font-weight-bold" style="font-size: 60px; color: #0D568B;">
                    {{ \App\Models\Lokasi::count() }}
                </div>   
                <p class="card-text mt-3" style="font-size: 20px;">Lokasi</p>
                <a href="tambah_lokasi" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#lokasiModal">Daftar Lokasi</a>
            </div>
        </div>
    </div>
</div>

<!-- Host Modal -->
<div class="modal fade" id="hostModal" tabindex="-1" aria-labelledby="hostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="hostModalLabel" style="font-size: 30px;"><b>Host</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach (\App\Models\Host::all() as $host)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($host->foto_profil) }}" class="rounded-lg me-3" width="40" height="40" alt="Profile Picture">
                                <h6 class="mb-0">{{ $host->nama }}</h6>
                            </div>
                            <div class="text-muted" style="margin-left: 20px;">{{ $host->divisi->nama_divisi }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Divisi Modal -->
<div class="modal fade" id="divisiModal" tabindex="-1" aria-labelledby="divisiModallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="divisiModallabel" style="font-size: 30px;"><b>Divisi</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach (\App\Models\divisi::all() as $divisi)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">{{ $divisi->nama_divisi }}</h6>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Lokasi Modal -->
<div class="modal fade" id="lokasiModal" tabindex="-1" aria-labelledby="lokasiModallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="lokasiModallabel" style="font-size: 30px;"><b>Lokasi</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @foreach (\App\Models\lokasi::all() as $lokasi)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">{{ $lokasi->ruangan }} {{ $lokasi->lantai }}</h6>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fadeUpElements = document.querySelectorAll('.fade-up');

        function handleScroll() {
            fadeUpElements.forEach(function (element) {
                if (isInViewport(element)) {
                    element.classList.add('visible');
                }
            });
        }

        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        handleScroll();
        window.addEventListener('scroll', handleScroll);
    });
</script>

<!-- Bootstrap 5 Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>

@endsection
