<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Todo extends Model {

    protected $table = 'todolists';
    protected $primaryKey = 'id';

    protected $fillable = ['text'];

    public function user(){
        return $this->belongsTo('App\User', 'author');
    }



}