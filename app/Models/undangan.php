<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class undangan extends Model
{
    use HasFactory;

    protected $table = 'undangan';

    protected $fillable = [
        'subjek',
        'keterangan',
        'waktu_temu',
        'waktu_kembali',
        'lokasi_id',
        'host_id',
        'status',
        'pengunjung_id'
    ];

    public function pengunjung()
    {
        return $this->belongsToMany(Pengunjung::class);
    }

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
