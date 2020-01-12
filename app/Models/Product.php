<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Product extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = "product_list";

    public static $rules = array(
        'name'=>'required',

        'price'=>'required',

        'visibility' => 'required',
    );


}