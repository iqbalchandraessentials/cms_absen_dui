<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaCuti extends Model
{
    protected $table = 'kuota_cuti';
    protected $fillable = [
        'user_id',
        'kuota_cuti',
        'sisa_cuti',
        'adjustment',
        'periode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
