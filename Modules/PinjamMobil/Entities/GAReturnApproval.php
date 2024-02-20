<?php

namespace Modules\PinjamMobil\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GAReturnApproval extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'ga_return_approvals';

    public function borrow()
    {
        return $this->hasOne(BorrowVehicles::class, 'borrow_id', 'id');
    }

    public function ga_pic()
    {
        $data = $this->belongsTo(User::class, 'ga_approval_id', 'id');
        return $data;
    }
    public function vehicles_return()
    {
        $data = $this->belongsTo(VehiclesReturn::class, 'return_id', 'id');
        return $data;
    }


}
