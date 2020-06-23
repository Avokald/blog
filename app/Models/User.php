<?php

namespace App\Models;

use App\Http\Controllers\Web\UserController;
use App\Traits\WithRelationScopes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(@OA\Xml(name="User"))
 */
class User extends Authenticatable
{
    /**
     * @OA\Property(property="id", type="integer", format="int64")
     * @OA\Property(property="name", type="string", example="Иван")
     * @OA\Property(property="slug", type="string", description="url-friendly name", example="ivan")
     * @OA\Property(property="description", type="string")
     * @OA\Property(property="image", type="string")
     * @OA\Property(property="created_at", type="string", format="date-time", example="2020-04-13 20:12:01")
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2020-05-20 12:45:39")
     *
     */

    use Notifiable;

    use Sluggable;

    use WithRelationScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'image',
        'banner',
        'description',
        'pinned_post_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    /*
     *******************************************************************************************************************
     Relationships
     *******************************************************************************************************************
    */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id')->published();
    }

    public function drafts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id')->draft();
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'user_id', 'id');
    }

    public function pinned_post()
    {
        return $this->hasOne(Post::class, 'id', 'pinned_post_id')->published();
    }

    public function post_likes()
    {
        return $this->hasMany(PostLike::class, 'user_id', 'id');
    }

    public function post_dislikes()
    {
        return $this->hasMany(PostDislike::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function informs()
    {
        return $this->hasMany(AbuseRequest::class, 'user_id', 'id');
    }

    public function abuses()
    {
        return $this->hasMany(AbuseRequest::class, 'target_id', 'id');
    }

    /*
     *******************************************************************************************************************
     Attributes
     *******************************************************************************************************************
    */
    public function getSluggedIdAttribute()
    {
        return $this->id . '-' . $this->slug;
    }



    /*
     *******************************************************************************************************************
     Scopes
     *******************************************************************************************************************
    */



    /*
     *******************************************************************************************************************
     Custom methods
     *******************************************************************************************************************
    */
    public function getPersonalPageLink()
    {
        if ($this->slug) {
            $link = $this->id . '-' . $this->slug;
        } else {
            $link = $this->id;
        }
        return route(UserController::SHOW_PATH_NAME, $link);
    }

    public function getBookmarkedPostsId()
    {
        $bookmarks = DB::select('SELECT post_id FROM bookmarks WHERE user_id = ?', [$this->id]);
        $bookmarks = array_map(function ($bookmark) {
                return $bookmark->post_id;
        }, $bookmarks);

        return $bookmarks;
    }

    public function getLikedPostsId()
    {
        $likedPosts = DB::select('SELECT post_id FROM post_likes WHERE user_id = ?', [$this->id]);
        $likedPosts = array_map(function ($post) {
                return $post->post_id;
        }, $likedPosts);

        return $likedPosts;
    }


    public function getDislikedPostsId()
    {
        $dislikedPosts = DB::select('SELECT post_id FROM post_dislikes WHERE user_id = ?', [$this->id]);
        $dislikedPosts = array_map(function ($post) {
                return $post->post_id;
        }, $dislikedPosts);

        return $dislikedPosts;
    }
}
