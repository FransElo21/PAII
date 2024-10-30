<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpModel extends Model
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
        'pengunjung_id',
    ];

    public function pengunjung(){
        return $this->belongsTo(Pengunjung::class);
    }

    public function host(){
        return $this->belongsTo(Host::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}
