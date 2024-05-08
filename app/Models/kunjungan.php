<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kunjungan extends Model
{
    protected $table = 'kunjungan';
    protected $fillable = ['pengunjung_id', 'undangan_id', 'check_in', 'check_out'];

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class);
    }

    public function undangan()
    {
        return $this->belongsTo(Undangan::class);
    }
}
