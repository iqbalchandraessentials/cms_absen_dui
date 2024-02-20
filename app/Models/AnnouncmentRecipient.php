<?php

namespace App\Models;

use App\Announcement;
use Illuminate\Database\Eloquent\Model;

class AnnouncmentRecipient extends Model
{
    protected $table = 'announcment_recipients';

    protected $fillable = [
        'announcment_id',
        'dept_id',
        'div_id',
        'branch_id',
    ];
    public function user()
    {
        return $this->belongsTo(Announcement::class,  'announcment_id', 'id');
    }
}
