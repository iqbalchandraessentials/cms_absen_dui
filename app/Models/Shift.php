<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'schedule_in',
        'schedule_out',
        'break_start',
        'urutan',
        'schedule_id',
        'break_end',
        'overtime_before',
        'overtime_after',
        'additional_break',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
