<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDislike extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
    ];

    protected $with = [
        'post',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
