<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $table = 'group_members';

    protected $fillable = ['uuid','undangan_id', 'name', 'email', 'phone','nik','check_in',
    'check_out',];

    public function undangan()
    {
        return $this->belongsTo(UndanganPengunjung::class, 'undangan_id');
    }
}

