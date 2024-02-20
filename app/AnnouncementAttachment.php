<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementAttachment extends Model
{
    protected $table = 'announcment_attachments';
    protected $fillable = [
        'announcment_id',
        'upload_file',
    ];
}
