<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];


    public function user()
    {
        return $this->hasMany(User::class, 'division_id', 'id');
    }
}
