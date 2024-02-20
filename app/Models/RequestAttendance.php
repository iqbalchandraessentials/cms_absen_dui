<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAttendance extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        'selected_date',
        'clock_in',
        'clock_out',
        'description',
        'upload_file',
        'approve',
        'approve_by',
        'request_date',
        'approve_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'name', 'division_id', 'job_position', 'department_id', 'photo_path', 'organization_id', 'nik', 'location_id');
    }
    public function approveby()
    {
        return $this->belongsTo(User::class, 'approve_by', 'id')->select(['id', 'name']);
    }
    public function attachment()
    {
        return $this->hasMany(RequesAttendanceAttachment::class, 'request_attendances_id', 'id')->select(['id', 'request_attendances_id', 'upload_file']);
    }
}
