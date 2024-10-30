<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class entry_point extends Authenticatable
{
    use HasFactory;

    protected $table = 'entry_point';

    protected $fillable = [
        'username', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
