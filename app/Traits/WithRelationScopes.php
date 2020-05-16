<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithRelationScopes
{
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
}