<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('detail_host.undangan', ['id' => $undangan->id]) }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('undangan.index') }}">Undangan</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $current }}</li>
    </ol>
</nav>
