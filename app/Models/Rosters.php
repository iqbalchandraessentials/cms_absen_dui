<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rosters extends Model
{
    protected $table = 'rosters';

    protected $fillable = [
        'user_id',
        'shift',
        'date',
        'off',
        'cr',
        'ct',
        'induksi'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
