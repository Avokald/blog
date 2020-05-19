<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const STATUS_SUBMITTED = 1;
    const STATUS_FULFILLED = 2;
    const STATUS_DENIED    = 3;

    protected $hidden = [
        'user_id',
    ];

    protected $fillable = [
        'post_id',
        'comment_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'offender_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'informer_id', 'id');
    }
}
