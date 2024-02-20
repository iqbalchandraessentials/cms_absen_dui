<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequesAttendanceAttachment extends Model
{
    protected $table = 'request_attendance_attachments';

    protected $fillable = ['request_attendances_id', 'upload_file'];
    

}
