<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestTimeoffAttachment extends Model
{
    protected $table = 'request_timeoff_attachment';

    protected $fillable = ['request_timeoff_id', 'upload_file'];

}
