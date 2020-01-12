<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Players extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = "operation";

    public static $rules = array(
        'name'=>'required',
        'nickName'=>'required',
        'lastip'=>'required',
    );


}