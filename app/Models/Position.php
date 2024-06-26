<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name'
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'job_level_id', 'id');
    }
}
