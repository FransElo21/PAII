<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'pengunjung';
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

    public function getRoleAttribute()
    {
        return 'pengunjung'; // Tentukan peran pengguna pengunjung
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function undangan()
    {
        return $this->belongsToMany(Undangan::class);
    }

}
