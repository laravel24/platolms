<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model 
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_tags';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
}
