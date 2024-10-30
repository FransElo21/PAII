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
        'status_pekerjaan',
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

    public function undangans()
    {
        return $this->belongsToMany(UndanganPengunjung::class, 'pengunjung_undangan', 'pengunjung_id', 'undangan_id');
    }

    public function undanganPengunjung()
    {
        return $this->hasMany(UndanganPengunjung::class);
    }

    public function UpModels(){
        return $this->hasMany(UpModel::class);
    }

    public function logs()
    {
        return $this->hasMany(logs_undangan_pengunjung::class, 'pengunjung_id');
    }


}
