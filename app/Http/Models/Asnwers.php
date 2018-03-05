<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Asnwers extends Model
{
     protected $table = 'answers';

    protected $fillable = [
        'questions_id',
        'answer',
        'correct'
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',  
        'updated_at',  
    ];


    /**
     *  Relation : Belongs to Questions 
     *
     *  @return App\Http\Models\Questions
     */
    public function question(){
    	return $this->belongsTo('App\Http\Models\Questions');
    }

}
