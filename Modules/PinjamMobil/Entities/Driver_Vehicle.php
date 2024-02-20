<?php

namespace Modules\PinjamMobil\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver_Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    protected $table = 'drivers';
}
