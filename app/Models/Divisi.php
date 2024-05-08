<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisi';

    // Definisikan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'nama_divisi',
    ];

    public function host()
    {
        return $this->hasOne(Host::class);
    }

}
