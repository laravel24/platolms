<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model 
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lessons';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'sub_title', 'order',
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
    protected $dates = [];

    /**
     * Get the lessons within a course
     */
    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }

    /**
     * Get the modules within a lesson
     */
    public function modules()
    {
        return $this->hasMany('App\Models\Module');
    }

}
