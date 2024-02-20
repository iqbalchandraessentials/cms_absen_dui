<?php

namespace Modules\PinjamMobil\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicleslocations extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'vehicles_locations';

    public function vehicle()
    {
        return $this->hasMany(Vehicles::class, 'lokasi_id', 'id');
    }

}
