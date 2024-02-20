<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaTimeoff extends Model
{
    // use HasFactory;

    protected $fillable = [
        'code',
        'timeoff_id',
        'kuota',
        'keterangan'
    ];
}
