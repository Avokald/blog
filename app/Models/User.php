<?php

namespace App\Models;

use App\Http\Controllers\Web\UserController;
use App\Traits\WithRelationScopes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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
        'public',
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
        'public',
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
}
