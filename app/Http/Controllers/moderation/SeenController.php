<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\moderation;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeenController extends Controller
{

    public function index(){

        return view('section.mod.seen');

    }

    public function speedsearch(){
        $Player = DB::connection('mongodb_server')->collection('players')->where('name', '=', strtolower($_POST['search_player']))->first();
        if ($Player != null){
            $Player = DB::connection('mongodb_server')->collection('players')->where('lastIp', '=', $Player['lastIp'])->take(10)->get();
            $json = [];

            foreach ($Player as $p){
                array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
            }

            return json_encode($json);
        }else{
            return "[]";
        }

    }

    public function longsearch(){
        $Player = DB::connection('mongodb_server')->collection('players')->where('name', '=', strtolower($_POST['search_player']))->first();

        if ($Player != null){
            $Data = DB::connection('mongodb_server')->collection('players')->where('lastIp', '=', $Player['lastIp'])->take(10)->get();
            $json = [];

            foreach ($Data as $p){
                array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
            }

            $Data = DB::connection('mongodb_server')->collection('connectionsLogs')->where('lastIp', '=', $Player['lastIp'])->get();

            foreach ($Data as $p){
                $Sp = DB::connection('mongodb_server')->collection('players')->where('name', '=', strtolower($p['username']))->first();
                //Check if is alredy checked
                $check = false;
                foreach ($json as $r){
                    if ($r['name'] == $Sp['name']){
                        $check = true;
                    }
                }
                if (!$check){
                    array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
                }
            }

            return json_encode($json);
        }else{
            //return "[]";
        }

    }


}