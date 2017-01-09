<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minor extends Model 
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'minors';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
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
     * Get the majors that belong to a minor
     */
    public function majors()
    {
        return $this->belongsToMany('App\Models\Major');
    }
}
