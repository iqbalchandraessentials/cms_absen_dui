<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcments';
    protected $fillable = [
        'user_id',
        'title',
        'name',
        'publish',
        'description',
    ];
    public function attachment()
    {
        return $this->hasMany(AnnouncementAttachment::class, 'announcment_id', 'id')->select(['announcment_id', 'upload_file']);
    }

    public function user()
    {
        return $this->belongsTo(User::class,  'user_id', 'id')->select('id', 'name', 'photo_path');
    }
}
