<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'active'
    ];


    public function department()
    {
        return $this->belongsTo(Department::class, 'organization_id', 'id')->select(['id', 'name']);
    }

    public function user()
    {
        return $this->hasMany(User::class, 'organization_id', 'id');
    }

}
