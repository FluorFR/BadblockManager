<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\section;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RedacController extends Controller
{


    public function blog(){

        $Blog = DB::connection('mongodb')->collection('blog')->get();

        return view("section.redac.blogview")->with("Blog", $Blog);

    }

}