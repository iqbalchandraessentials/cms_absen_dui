<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendances extends Model
{
    // use HasFactory;
    protected $fillable = [
        'check_in',
        'check_out',
        'user_id',
        'approval_in',
        'longitude_in',
        'latitude_in',
        'description_in',
        'longitude_out',
        'latitude_out',
        'description_out',
        'approval_out',
        'img_check_in',
        'img_check_out',
        'live_absen_in',
        'live_absen_out',
        'overtime_after',
        'overtime_before',
        'timeoff_id',
        'status',
        'shift_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,  'user_id', 'id');
    }

    public function organization()
    {
        return $this->hasMany(User::class,  'organization_id', Auth::user()->organization_id);
    }

    public function timeoff()
    {
        return $this->belongsTo(RequestTimeoff::class, 'timeoff_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function typeTimeoff()
    {
        return $this->belongsTo(Timeoff::class, 'status', 'code');
    }
}
