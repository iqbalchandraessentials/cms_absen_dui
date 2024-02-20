<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'effective_date',
        'override_national_holiday',
        'override_company_holiday',
        'override_special_holiday',
        'flexible',
        'include_late',
        'shift_id',
        'initial_shift',
        'active',
    ];

    public function shift()
    {
        return $this->hasMany(Shift::class, 'schedule_id', 'id')->orderBy('urutan', 'ASC');
    }

    public function user_schedule()
    {
        return $this->hasMany(user_schedules::class, 'schedule_id', 'id');
    }
}
