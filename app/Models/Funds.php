<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Funds extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = "funds";


    public static $rules = array(
        'date'=>'required',
        'unique-id'=>'required',
        'name'=>'required',
        'gateway'=>'required',
        'points'=>'required',
        'price'=>'required',
        'comment'=>'required',
    );



}