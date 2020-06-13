<?php

namespace App\Models;

use App\Http\Controllers\Web\TagController;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(@OA\Xml(name="Tag"), required={"id", "title"})
 */
class Tag extends Model
{
    /**
     * @OA\Property(property="id", type="integer", format="int64")
     * @OA\Property(property="title", type="string")
     * @OA\Property(property="created_at", type="string", format="date-time", example="2020-04-13 20:12:01")
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2020-05-20 12:45:39")
     */

    protected $fillable = [
        'title',
    ];

    protected $appends = [
        'link',
    ];

    /*
     *******************************************************************************************************************
     Relationships
     *******************************************************************************************************************
    */
    public function posts()
    {

    }


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
    public function getLinkAttribute()
    {
        $link = $this->title;

        return route(TagController::SHOW_PATH_NAME, $link);
    }
}
