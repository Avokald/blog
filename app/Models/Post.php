<?php

namespace App\Models;

use App\Http\Controllers\Web\PostController;
use App\Traits\WithRelationScopes;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sluggable;

    use WithRelationScopes;

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'json_content',
        'user_id',
        'category_id',
        'tags',
        'created_at',
    ];

    protected $casts = [
        'status' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'tags' => 'array',
    ];

    protected $with = [
        'author',
    ];

    protected $withCount = [
        'bookmarks',
        'post_likes',
        'post_dislikes',
        'comments',
    ];

    // TODO
    // Rating, bookmarks count, views into separate database
    protected $appends = [
        'rating',
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
                'source' => 'title'
            ]
        ];
    }

    /*
     *******************************************************************************************************************
     Relationships
     *******************************************************************************************************************
    */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'post_id', 'id');
    }

    public function post_likes()
    {
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }

    public function post_dislikes()
    {
        return $this->hasMany(PostDislike::class, 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'id');
    }


    /*
    ********************************************************************************************************************
     Attributes
    ********************************************************************************************************************
    */
    public function getRatingAttribute()
    {
        return $this->post_likes_count - $this->post_dislikes_count;
    }

    public function getSluggedIdAttribute()
    {
        return $this->id . '-' . $this->slug;
    }

    /*
    ********************************************************************************************************************
     Scopes
    ********************************************************************************************************************
    */
    public function scopePublished(Builder $query)
    {
        return $query->where('status', Post::STATUS_PUBLISHED);
    }

    public function scopeDraft(Builder $query)
    {
        return $query->where('status', Post::STATUS_DRAFT);
    }


    public function scopeLast24Hours(Builder $query)
    {
        return $query->where('created_at', '>', Carbon::now()->subHours(24));
    }

    public function scopeLast7Days(Builder $query)
    {
        return $query->where('created_at', '>', Carbon::now()->subDays(7));
    }

    public function scopeLast30Days(Builder $query)
    {
        return $query->where('created_at', '>', Carbon::now()->subDays(30));
    }

    public function scopeLast365Days(Builder $query)
    {
        return $query->where('created_at', '>', Carbon::now()->subDays(365));
    }

    public function scopeNoScope(Builder $query)
    {
        return $query;
    }

    /*
    ********************************************************************************************************************
    Custom methods
    ********************************************************************************************************************
    */
    public function getShowLink()
    {
        if ($this->slug) {
            $link = $this->id . '-' . $this->slug;
        } else {
            $link = $this->id;
        }
        return route(PostController::SHOW_PATH_NAME, $link);
    }
}
