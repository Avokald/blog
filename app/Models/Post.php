<?php

namespace App\Models;

use App\Http\Controllers\Web\PostController;
use App\Traits\WithRelationScopes;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(@OA\Xml(name="Post"), required={"id", "title", "slug", "status", "user_id", "category_id", "created_at", "updated_at"})
 *
 */
class Post extends Model
{
    /**
     * @OA\Property(property="id", type="integer", format="int64")
     * @OA\Property(property="title", type="string", example="Заголовок")
     * @OA\Property(property="slug", type="string", description="url-friendly title", example="zagolovok")
     * @OA\Property(property="excerpt", type="string", description="Short introduction to the content")
     * @OA\Property(property="content", type="string")
     * @OA\Property(property="status", type="integer", enum={"STATUS_PUBLISHED = 1", "STATUS_DRAFT = 2"})
     * @OA\Property(property="view_count", type="integer", format="int64")
     * @OA\Property(property="bookmarks_count", type="integer", format="int64")
     * @OA\Property(property="rating", type="integer", format="int64")
     * @OA\Property(property="user_id", type="integer", format="int64")
     * @OA\Property(property="author", ref="#/components/schemas/User")
     * @OA\Property(property="category_id", type="integer", format="int64")
     * @OA\Property(property="category", ref="#/components/schemas/Category")
     * @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     * @OA\Property(property="comments", type="array", @OA\Items(ref="#/components/schemas/Comment"))
     * @OA\Property(property="created_at", type="string", format="date-time", example="2020-04-13 20:12:01")
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2020-05-20 12:45:39")
     *
     */

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
        'view_count',
        'json_content',
        'user_id',
        'category_id',
        'tags',
    ];

    protected $casts = [
        'status' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'view_count' => 'integer',
        'tags' => 'array',
    ];

    protected $with = [
        'author',
        'category',
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
        'link',
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

    public function abuse_requests()
    {
        return $this->hasMany(AbuseRequest::class, 'post_id', 'id');
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

    public function getLinkAttribute()
    {
        return route(PostController::SHOW_PATH_NAME, $this->slugged_id);
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
