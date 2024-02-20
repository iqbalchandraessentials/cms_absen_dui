<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $fillable = [
        'name',
        'code'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'department_id', 'id')->select(['id', 'name']);
    }

    public function user()
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }
}
