<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AchatController extends Controller
{
    public function index($uuid){

        $buy = DB::connection('mongodb')->collection('buy_logs')->where('uniqueId', $uuid)->orderby('date','DESC')->get();
        $funds = DB::connection('mongodb')->collection('funds')->where('uniqueId', $uuid)->orderby('date','DESC')->get();


        return view('users.achat')->with('funds' , $funds)->with('buy', $buy);

    }


    public function action(){

    }


}