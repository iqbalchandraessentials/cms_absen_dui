<?php

namespace Modules\PinjamMobil\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KMHistory extends Model
{
    use HasFactory;

    protected $fillable = ['first_km', 'next_km'];

    protected $table = 'km_history';
}
