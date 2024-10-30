<?php

namespace App\Models;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UndanganPengunjung extends Model
{
    use HasFactory;

    protected $table = 'undangan_pengunjung';

    protected $fillable = [
        'subject', 
        'keterangan', 
        'status', 
        'kunjungan_dari', 
        'waktu_temu', 
        'waktu_kembali',  
        'host_id', 
        'lokasi_id',
        'pengunjung_id', 
        'type',
        'keperluan',
        'alasan_penolakan'
    ];

    public static function validKeperluan()
    {
        return [
            'keperluan' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!in_array($value, ['pribadi', 'pekerjaan'])) {
                    $fail('The '.$attribute.' must be either "pribadi" or "pekerjaan".');
                }
            }],
        ];
    }

    public function host()
    {
        return $this->belongsTo(Host::class, 'host_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
    
    public function pengunjungs()
    {
        return $this->belongsToMany(Pengunjung::class, 'pengunjung_undangan', 'undangan_id', 'pengunjung_id');
    }
    
    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class, 'pengunjung_id');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class, 'undangan_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function logs()
    {
        return $this->hasOne(logs_undangan_pengunjung::class, 'undangan_id');
    }


}
