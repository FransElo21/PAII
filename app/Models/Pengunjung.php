<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengunjung extends Authenticatable
{
    use Notifiable;

    // Definisikan nama tabel jika berbeda dengan konvensi Laravel
    protected $table = 'pengunjung';

    // Definisikan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'namaLengkap',
        'username',
        'password',
        'jenis_kelamin',
        'nomor_telepon',
        'email',
        'alamat',
        'foto_profil'
    ];

    // Tetapkan kolom-kolom yang harus disembunyikan (hidden)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Definisikan fungsi accessor untuk mendapatkan peran pengguna
    public function getRoleAttribute()
    {
        return 'pengunjung'; // Tentukan peran pengguna pengunjung
    }

    public function undangan()
    {
        return $this->belongsToMany(UndanganPengunjung::class, 'pengunjung_undangan');
    }
}
