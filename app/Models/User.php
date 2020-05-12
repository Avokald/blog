<?php

namespace App\Models;

use App\Http\Controllers\Web\UserController;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    use Sluggable;

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


    /*
     *******************************************************************************************************************
     Custom attributes
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
    /**
     * Function to order relationships
     * @param Builder $query
     * @param $relation string - any relationship name that is
     * @param $order string - column to order by
     * @param $direction string - direction to order by
     * @return Builder
     */
    public function scopeWithRelationOrderedBy(Builder $query, string $relation, string $order, string $direction)
    {
        return $query->with([
            $relation => function($subquery) use ($order, $direction) {
                return $subquery->orderBy($order, $direction);
            }
        ]);
    }


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
