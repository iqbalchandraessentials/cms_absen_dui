<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeAttachment extends Model
{
    protected $table = 'overtime_attachment';

    protected $fillable = ['overtime_id', 'upload_file'];
}
