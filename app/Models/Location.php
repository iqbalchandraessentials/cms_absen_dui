<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
        'longitude',
        'latitude',
        'radius',
        'organization_id',
        'active',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id')->select(['id', 'name']);
    }

    public function user()
    {
        return $this->hasMany(User::class, 'location_id', 'id');
    }

}
