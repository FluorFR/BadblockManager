<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\section;


use App\Http\Controllers\Controller;

class ForumController extends Controller
{


    public function index(){
        return view('section.forum.index');
    }

}