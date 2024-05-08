<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'ruangan',
        'lantai',
    ];

    public function undanganPengunjung()
    {
        return $this->hasMany(UndanganPengunjung::class, 'lokasi_id');
    }

    public function host()
    {
        return $this->hasOne(Host::class, 'lokasi_id');
    }

}
