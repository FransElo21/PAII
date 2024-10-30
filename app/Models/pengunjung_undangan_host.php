<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengunjung_undangan_host extends Model
{
    use HasFactory;
    
    protected $table = 'pengunjung_undangan_host';
    protected $fillable = [
        'undangan_id',
        'name',
        'email',
        'phone',
        'NIK',
        'check_in',
        'check_out',
    ];

    public function invitation()
    {
        return $this->belongsTo(undangan_host::class);
    }

    public function undanganHost()
    {
        return $this->belongsTo(undangan_host::class, 'undangan_id');
    }
}
