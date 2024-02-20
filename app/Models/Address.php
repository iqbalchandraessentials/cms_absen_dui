<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = ['id_employee', 'address', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'type'];

}
