<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Questionair extends Model
{
    protected $table = 'questionair';

    protected $fillable = [
        'user_id',
        'name',
        'time',
        'duration',
        'canResume',
        'published'
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




    public function getDurationTimeAttribute(){
    	return $this->time.' '.$this->duration;
    }



    public function isPublished(){
    	if($this->published == 'Yes'){
    		return true;
    	}else{
    		return false;
    	}
    }

    /**
     *  Relation : Belongs to User 
     *
     *  @return App\User
     */
    public function user(){
    	return $this->belongsTo('App\User');
    }

    /**
     *  Relation : Has many Types 
     *
     *  @return App\User
     */
    public function type(){
        return $this->hasMany('App\Http\Models\Type');
    }

}
