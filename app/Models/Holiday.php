<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $table = 'holiday';

    protected $fillable = ['holiday_date', 'holiday_name', 'is_national_holiday'];
}
