<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class College extends Model 
{
    use SoftDeletes;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'colleges';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'contact', 'email', 'phone', 'options'
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

    /**
     * Get the majors that belong to a college
     */
    public function majors()
    {
        return $this->hasMany('App\Models\Major');
    }

    /**
     * Get the minors that belong to a college
     */
    public function minors()
    {
        return $this->hasMany('App\Models\Minor');
    }

}
