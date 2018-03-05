<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'type_id',
        'question'
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
     *  Relation : Belongs to type 
     *
     *  @return App\Http\Models\Type
     */
    public function type(){
    	return $this->belongsTo('App\Http\Models\Type');
    }



    /**
     *  Relation : has many Asnwers 
     *
     *  @return App\Http\Models\Asnwers
     */
    public function answers(){
    	return $this->hasMany('App\Http\Models\Asnwers');
    }

}
