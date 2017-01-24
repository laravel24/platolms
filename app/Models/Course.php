<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model 
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'revision_id', 'subject_id', 'level', 'number', 'title', 'slug', 'sub_title', 'description', 'img', 'online', 'campus', 'options'
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
     * Get the subject of the course
     */
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    /**
     * Get the tags of the course
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\CourseTag', 'courses_tags');
    }

    /**
     * Get the prerequiste courses of the course
     */
    public function prerequisites()
    {
        return $this->belongsToMany('App\Models\Course', 'courses_prerequisites', 'course_id', 'course_prerequisite_id');
    }

    /**
     * Get the lessons within a course
     */
    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson');
    }
}
