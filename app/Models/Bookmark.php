<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(@OA\Xml(name="Bookmark"), required={"id", "user_id", "post_id"})
 */
class Bookmark extends Model
{
    /**
     * @OA\Property(property="id", type="integer", format="int64")
     * @OA\Property(property="user_id", type="integer", format="int64")
     * @OA\Property(property="author", ref="#/components/schemas/User")
     * @OA\Property(property="post_id", type="integer", format="int64")
     * @OA\Property(property="post", ref="#/components/schemas/Post")
     * @OA\Property(property="created_at", type="string", format="date-time", example="2020-04-13 20:12:01")
     */

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
