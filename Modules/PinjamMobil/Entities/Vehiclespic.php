<?php

namespace Modules\PinjamMobil\Entities;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiclespic extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'active'];

    protected $table = 'vehicles_pic';


    public function users()
    {
        $data = $this->belongsTo(User::class, 'user_id', 'id');
        return $data;
    }

    public function vehicle()
    {
        return $this->hasMany(Vehicles::class, 'pic_id', 'id');
    }
}
