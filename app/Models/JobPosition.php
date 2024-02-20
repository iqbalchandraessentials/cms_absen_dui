<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $table = 'job_positions';

    protected $fillable = [
        'name',
        'status',
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'job_position', 'id');
    }
}
