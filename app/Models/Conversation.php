<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model 
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'conversations';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id', 'author_id', 'title', 'content', 'attachment',
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

}
