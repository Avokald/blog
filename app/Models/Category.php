<?php

namespace App\Models;

use App\Http\Controllers\Web\CategoryController;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(@OA\Xml(name="Category"))
 */
class Category extends Model
{
    /**
     * @OA\Property(property="id", type="integer", format="int64")
     * @OA\Property(property="title", type="string", example="Категория")
     * @OA\Property(property="slug", type="string", description="url-friendly title", example="kategoriya")
     * @OA\Property(property="description", type="string")
     * @OA\Property(property="image", type="string")
     * @OA\Property(property="banner", type="string")
     * @OA\Property(property="posts", type="array", @OA\Items(ref="#/components/schemas/Post"))
     * @OA\Property(property="created_at", type="string", format="date-time", example="2020-04-13 20:12:01")
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2020-05-20 12:45:39")

    */
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'banner',
    ];

    protected $appends = [
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id')->published();
    }

    public function scopeWithPostsOrderedBy(Builder $query, $order, $direction)
    {
        return $query->with([
            'posts' => function($subquery) use ($order, $direction) {
                return $subquery->orderBy($order, $direction);
            }
        ]);
    }

    public function getLinkAttribute()
    {
        return route(CategoryController::SHOW_PATH_NAME, $this->slug);
    }

}
