<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/05/2018
 * Time: 22:20
 */

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class Notifications extends Model
{

    use CrudTrait;
    use RevisionableTrait;

    protected $table = 'notifications';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id','updated_at', 'created_at','text','icon','link','title'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


}