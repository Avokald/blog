<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'reply_id',
        'parent_1_id',
        'parent_2_id',
        'parent_3_id',
    ];

    protected $with = [
        'author',
    ];


    /*
     *******************************************************************************************************************
     Relationships
     *******************************************************************************************************************
    */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id', 'id');
    }

    public function repliedTo()
    {
        return $this->belongsTo(Comment::class, 'reply_id', 'id');
    }


    /*
    ********************************************************************************************************************
     Attributes
    ********************************************************************************************************************
    */


    /*
    ********************************************************************************************************************
     Scopes
    ********************************************************************************************************************
    */


    /*
    ********************************************************************************************************************
    Custom methods
    ********************************************************************************************************************
    */

    /*
    SELECT DISTINCT *
#   IFNULL(c4.id,      IFNULL(c3.id,       IFNULL(c2.id, c1.id))) as id,
#   IFNULL(c4.content, IFNULL(c3.content , IFNULL(c2.content , c1.content ))) as content,
#   IFNULL(c4.user_id, IFNULL(c3.user_id, IFNULL(c2.user_id, c1.user_id))) as user_id,
#   IFNULL(c4.post_id, IFNULL(c3.post_id, IFNULL(c2.post_id, c1.post_id))) as post_id,
#   IFNULL(c4.reply_id, IFNULL(c3.reply_id, IFNULL(c2.reply_id, c1.reply_id))) as reply_id,
#   IFNULL(c4.parent_1_id, IFNULL(c3.parent_1_id, IFNULL(c2.parent_1_id, c1.parent_1_id))) as parent_1_id,
#   IFNULL(c4.parent_2_id, IFNULL(c3.parent_2_id , IFNULL(c2.parent_2_id , c1.parent_2_id ))) as parent_2_id,
#   IFNULL(c4.parent_3_id, IFNULL(c3.parent_3_id, IFNULL(c2.parent_3_id, c1.parent_3_id))) as parent_3_id,
#   IFNULL(c4.created_at, IFNULL(c3.created_at, IFNULL(c2.created_at, c1.created_at))) as created_at,
#   IFNULL(c4.updated_at, IFNULL(c3.updated_at, IFNULL(c2.updated_at, c1.updated_at))) as updated_at
    FROM comments as c1
    LEFT JOIN
    comments as c2
    ON c1.id = c2.reply_id
    LEFT JOIN
    comments as c3
    ON c1.id = c3.parent_1_id
    LEFT JOIN
    comments as c4
    ON c1.id = c4.parent_2_id
    WHERE c1.post_id = 1
    AND c1.reply_id IS NULL
    */
}
