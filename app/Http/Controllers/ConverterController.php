<?php
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 22/02/2019
 * Time: 17:09
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class ConverterController extends Controller
{

    public static function convertIDPseudo($id){
        return DB::table('users')->where('id', $id)->value('name');
    }

    public static function convertIDSection($id){
        return DB::table('sections')->where('section_id', $id)->value('section_name');
    }

    public static  function convertSectionID($section){
        return DB::table('sections')->where('section_name', $section)->value('section_id');
    }

}