@extends('layouts.app')

@section('content')
<div class="col-xl-6">
    <div class="card text-center">
        <div class="card-header">
            <i class="fa-solid fa-envelope-open-text fa-4x text-black"></i>
        </div>
        <div class="card-body">
            <h2>Undangan</h2>
            <p>Mendapat undangan dari host/penerimaan tamu?</p>
        </div>
        <a href="javascript:void(0);" class="btn btn-primary btn-card">QR Code</a>
    </div>
</div>
<div class="col-xl-6">
    <div class="card text-center">
        <div class="card-header">
            <i class="fa-solid fa-user-clock fa-4x text-black"></i>
        </div>
        <div class="card-body">
            <h2>Membuat Janji</h2>
            <p>Membuat janji dengan host/penerima tamu?</p>
        </div>
        <a href="/janji_temu" class="btn btn-primary btn-card">Buat Janji</a>
    </div>
</div>

@endsection
