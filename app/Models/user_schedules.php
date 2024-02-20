<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_schedules extends Model
{
    protected $table = 'user_schedules';

    protected $fillable = [
        'user_id',
        'schedule_id',
        'effective_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

}
