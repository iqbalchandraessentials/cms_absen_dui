<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCutiTahunan extends Model
{
    protected $table = 'log_cuti_tahunan';

    protected $fillable = [
        'user_id',    'total_pengajuan',    'cuti_exists'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
