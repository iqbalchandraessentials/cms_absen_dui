<?php

namespace Modules\PinjamMobil\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowVehicles extends Model
{
    use HasFactory;

    protected $fillable = ['approved', 'approved_date', 'status', 'driver_id'];

    protected $table = 'borrow_vehicles';

    public function ga_approve()
    {
        return $this->hasOne(GABorrowVehicles::class, 'borrow_id', 'id');
    }

    public function vehicles()
    {
        $data = $this->belongsTo(Vehicles::class, 'vehicles_id', 'id');
        return $data;
    }

    public function users()
    {
        $data = $this->belongsTo(User::class, 'user_id', 'id');
        return $data;
    }

    public function drivers()
    {
        $data = $this->belongsTo(Driver_Vehicle::class, 'driver_id', 'id');
        return $data;
    }

    public function return_vehicles()
    {
        $data = $this->belongsTo(VehiclesReturn::class, 'id', 'borrow_id');
        return $data;
    }

    public function km_history()
    {
        $data = $this->hasOne(KMHistory::class, 'borrowing_id', 'id')->latest();
        return $data;
    }


    public function attachment()
    {
        return $this->hasMany(VehiclesReturnAttachment::class, 'borrow_id', 'id')->select('upload_file');
    }
}
