<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        // 'schedule_id',
        'selected_date',
        'overtime_duration_before',
        'overtime_duration_after',
        'request_date',
        'approve_date',
        'description',
        'upload_file',
        'approve',
        'approve_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,  'user_id', 'id')->select('id', 'name','nik', 'division_id', 'location_id', 'job_position', 'photo_path', 'department_id', 'organization_id' );

    }

    public function approveby()
    {
        return $this->belongsTo(User::class, 'approve_by', 'id')->select(['id', 'name']);
    }

    public function attachment()
    {
        return $this->hasMany(OvertimeAttachment::class, 'overtime_id', 'id')->select('id', 'overtime_id', 'upload_file');
    }
}
