<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;


class Host extends AuthenticatableUser implements Authenticatable
{
    use HasFactory;

    protected $table = 'host';

    // Definisikan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'nama',
        'username',
        'password',
        'jenis_kelamin',
        'nomor_telepon',
        'email',
        'alamat',
        'lokasi_id',
        'divisi_id',
        'foto_profil'
    ];

    // Tetapkan kolom-kolom yang harus disembunyikan (hidden)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function undanganPengunjung()
    {
        return $this->hasMany(UndanganPengunjung::class, 'host_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

}
