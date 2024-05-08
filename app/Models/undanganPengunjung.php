<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganPengunjung extends Model
{
    use HasFactory;

    protected $table = 'undangan_pengunjung';

    protected $fillable = [
        'subject',
        'keterangan',
        'waktu_temu',
        'waktu_kembali',
        'lokasi_id',
        'host_id',
        'status',
    ];

    public function host()
    {
        return $this->belongsTo(Host::class, 'host_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
