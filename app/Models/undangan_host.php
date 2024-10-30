<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class undangan_host extends Model
{
    use HasFactory;
    protected $table = 'undangan_host';
    protected $fillable = [
        'subject', 
        'keterangan', 
        'status', 
        'kunjungan_dari', 
        'waktu_temu', 
        'waktu_kembali',  
        'host_id', 
        'lokasi_id',
        'keperluan',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function pengunjungundangan_host()
    {
        return $this->hasMany(pengunjung_undangan_host::class, 'undangan_id');
    }

    public function visitors()
    {
        return $this->hasMany(pengunjung_undangan_host::class, 'undangan_id');
    }
}
