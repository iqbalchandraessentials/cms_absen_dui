<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cuti_tahunan extends Model
{
    // use HasFactory;
    protected $table = 'cuti_tahunan';

    protected $fillable = [
        'name',
        'mass_leave',
    ];
}
