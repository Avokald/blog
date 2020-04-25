<?php

namespace App\Models;

use App\Http\Controllers\Web\ArticleController;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Sluggable;

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'json_content',
        'user_id',
        'category_id',
        'tags',
    ];

    protected $casts = [
        'status' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'tags' => 'array',
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

    public function scopePublished(Builder $query)
    {
        return $query->where('status', Article::STATUS_PUBLISHED);
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

    public function getShowLink()
    {
        if ($this->slug) {
            $link = $this->id . '-' . $this->slug;
        } else {
            $link = $this->id;
        }
        return route(ArticleController::SHOW_PATH_NAME, $link);
    }
}
