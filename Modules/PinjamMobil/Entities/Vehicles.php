<?php

namespace Modules\PinjamMobil\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicles extends Model
{
    use HasFactory;

    protected $fillable = ['lokasi_id', 'last_km'];

    protected $table = 'vehicles';

    public function vehicle_locations()
    {
        $data = $this->belongsTo(Vehicleslocations::class, 'lokasi_id', 'id');
        return $data;
    }

    public function vehicle_pic()
    {
        $data = $this->belongsTo(Vehiclespic::class, 'pic_id', 'id');
        // return $this->hasOne(Vehiclespic::class, 'pic_id');
        return $data;
    }


    public function borrowVehicles()
    {
        return $this->hasMany(BorrowVehicle::class, 'vehicle_id');
    }


    public function borrow($currentDate)
    {
        return $this->hasOne(BorrowVehicles::class, 'vehicles_id', 'id')->whereDate('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate)->where('approved', '1');
    }

    public function km()
    {
        return $this->hasMany(KMHistory::class, 'vehicles_id', 'id');
    }
}
