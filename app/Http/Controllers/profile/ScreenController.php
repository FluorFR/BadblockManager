<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ScreenController extends Controller
{
    public function index(){
        $User = strtolower(Auth::user()->name);
        $Count = DB::connection('mongodb')->collection('log_upload')->where('user', '=', $User)->count();

        $Screen = DB::connection('mongodb')->collection('log_upload')->where('user', '=', $User)->orderBy('date', 'DESC')->take(20)->get();

        if ($Count > 20){
            $Page = floor($Count / 20);
        }else{
            $Page = 0;
        }

        return view('profil.screen')->with('Screen', $Screen)->with('Page', $Page);
    }

    public function page($id){

        $Page = $id;
        $Skip = $Page * 20;

        $User = strtolower(Auth::user()->name);
        $Count = DB::connection('mongodb')->collection('log_upload')->where('user', '=', $User)->count();

        $Screen = DB::connection('mongodb')->collection('log_upload')->where('user', '=', $User)->orderBy('date', 'DESC')->skip($Skip)->take(20)->get();

        if ($Count > 20){
            $Page = floor($Count / 20);
        }else{
            $Page = 0;
        }

        return view('profil.screen')->with('Screen', $Screen)->with('Page', $Page);
    }



}