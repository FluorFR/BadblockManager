<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Items extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = "items";

    public static $rules = array(
        'name'=>'required',
    );


}