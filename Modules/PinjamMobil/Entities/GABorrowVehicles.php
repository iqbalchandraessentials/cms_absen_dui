<?php

namespace Modules\PinjamMobil\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GABorrowVehicles extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    protected $table = 'ga_borrow_approvals';

    public function borrow()
    {
        return $this->belongsTo(BorrowVehicles::class, 'borrow_id', 'id');
    }

    public function ga_pic()
    {
        $data = $this->belongsTo(User::class, 'ga_approval_id', 'id');
        return $data;
    }
}
