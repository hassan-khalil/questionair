<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';

    protected $fillable = [
        'questionair_id',
        'question_type'
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
     *  Relation : Belongs to Questionair 
     *
     *  @return App\Http\Models\Questionair
     */
    public function questionair(){
    	return $this->belongsTo('App\Http\Models\Questionair');
    }



    /**
     *  Relation : has many Questions 
     *
     *  @return App\Http\Models\Questions
     */
    public function questions(){
    	return $this->hasMany('App\Http\Models\Questions');
    }
}
