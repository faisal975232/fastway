<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    use HasFactory;

    protected $table = 'crypto';

    protected $fillable = [
        'cid',
        'symbol',
        'name',
        'platform'
    ];
}
