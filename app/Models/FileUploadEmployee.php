<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUploadEmployee extends Model
{
    protected $table = 'employee_file_upload';

    protected $fillable = ['id_employee', 'file_name', 'type'];

}
