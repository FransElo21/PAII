<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logs_undangan_pengunjung extends Model
{
    use HasFactory;

    protected $table = 'logs_undangan_pengunjung';

    protected $fillable = [
        'undangan_id',
        'pengunjung_id',
        'check_in',
        'check_out',
    ];

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class, 'pengunjung_id');
    }

    public function undangan_pengunjung() {
        return $this->belongsTo(UndanganPengunjung::class, 'undangan_id'); // Pastikan ini adalah nama kolom yang benar
    }

}
