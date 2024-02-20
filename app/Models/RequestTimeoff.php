<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTimeoff extends Model
{
    protected $table = 'request_timeoff';
    protected $fillable = [
        'user_id',
        'timeoff_id',
        'start_date',
        'end_date',
        'description',
        'delegation_id',
        'upload_file',
        'request_date',
        'approve_date',
        'approve',
        'approve_by',
    ];

    public function timeoff()
    {
        return $this->belongsTo(Timeoff::class, 'timeoff_id', 'id')->select(['id', 'name', 'code']);
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id')->select(['id', 'name', 'division_id', 'job_position', 'nik', 'photo_path', 'department_id', 'location_id', 'organization_id']);
    }

    public function delegation()
    {
        return $this->belongsTo(User::class, 'delegation_id', 'id')->select(['id', 'name', 'photo_path']);
    }

    public function approveby()
    {
        return $this->belongsTo(User::class, 'approve_by', 'id')->select(['id', 'name']);
    }


    public function attachment()
    {
        return $this->hasMany(RequestTimeoffAttachment::class, 'request_timeoff_id', 'id')->select(['id', 'request_timeoff_id', 'upload_file']);
    }

    public function kuota_timeoff()
    {
        return $this->belongsTo(KuotaTimeoff::class, 'timeoff_id', 'id')->select(['id', 'code', 'kuota']);
    }
}
