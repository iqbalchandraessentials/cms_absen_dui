<?php

namespace Modules\PinjamMobil\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiclesReturn extends Model
{
    use HasFactory;
    protected $table = 'return_vehicles';

    protected $fillable = [ 'borrow_id', 'body', 'lampu', 'ban', 'ac', 'mesin', 'description', 'request_date'];

    public function borrow()
    {
        return $this->belongsTo(BorrowVehicles::class, 'borrow_id', 'id');
    }

}
