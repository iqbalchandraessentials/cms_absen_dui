<?php

namespace Modules\PinjamMobil\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiclesReturnAttachment extends Model
{
    use HasFactory;

    protected $table = 'borrow_vehicles_attachment';

    protected $fillable = [ 'borrow_id', 'upload_file'];

}
