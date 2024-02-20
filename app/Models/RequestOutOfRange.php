<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOutOfRange extends Model
{
    // request_outofrange
    protected $table = 'request_outofrange';
    protected $fillable = [
        'attendance_id',
        'user_id',
        'type',
        'longitude',
        'request_date',
        'approve_date',
        'image',
        'latitude',
        'description',
        'approve_by',
        'approval',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'name', 'division_id', 'job_position', 'department_id', 'photo_path', 'organization_id', 'nik', 'location_id');
    }

    public function approveby()
    {
        return $this->belongsTo(User::class, 'approve_by', 'id')->select(['id', 'name']);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendances::class, 'attendance_id', 'id')->select(['id', 'img_check_in', 'img_check_out']);
    }

}
