<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengunjungUndangan extends Model
{
    use HasFactory;
    protected $table = 'pengunjung_undangan';
    protected $fillable = ['pengunjung_id', 'undangan_id'];
}
