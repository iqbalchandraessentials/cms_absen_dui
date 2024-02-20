<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = ['nik', 'name', 'phone', 'other_phone', 'birth_place', 'birth_date', 'religion', 'citizen_id', 'marital_status', 'status_ptkp', 'npwp', 'kk', 'mother_name'];

}
