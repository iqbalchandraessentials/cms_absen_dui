<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestShift extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        'selected_date',
        'shift_id',
        'description',
        'approve_by',
        'approve'
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['id', 'name', 'photo_path' ]);
    }

}
