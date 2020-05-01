<?php

namespace App\Models;

use App\Http\Controllers\Web\CategoryController;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
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


    public function getLinkAttribute()
    {
        return route(CategoryController::SHOW_PATH_NAME, $this->slug);
    }

}
