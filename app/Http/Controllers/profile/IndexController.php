<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\profile;


use App\Models\Funds;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Operation;
use App\Models\Product;


class IndexController extends Controller
{
    public function index(){

        return view('users.search');
    }


    public function search(){

        $PlayerOne = DB::connection('mongodb_server')->collection('players')->where('name', '=', strtolower($_POST['search_player']))->first();
        $Player = DB::connection('mongodb_server')->collection('players')->where('name', 'like', strtolower($_POST['search_player']) .'%')->take(10)->get();
        $json = [];

        if ($PlayerOne != null){
            array_push($json, ['name' => $PlayerOne['name'], 'uniqueId' => $PlayerOne['uniqueId']]);
            foreach ($Player as $p){
                if ($p['name'] != $PlayerOne['name']){
                    array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
                }
            }

        }else{
            foreach ($Player as $p){
                array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
            }
        }



        return json_encode($json);
    }

    public function searchip(){
        $PlayerOne = DB::connection('mongodb_server')->collection('players')->where('lastIp', 'like', $_POST['search_player'] .'%')->first();
        $Player = DB::connection('mongodb_server')->collection('players')->where('lastIp', 'like', $_POST['search_player'] .'%')->take(10)->get();
        $json = [];

        if ($PlayerOne != null){
            array_push($json, ['name' => $PlayerOne['name'], 'uniqueId' => $PlayerOne['uniqueId']]);
            foreach ($Player as $p){
                if ($p['name'] != $PlayerOne['name']){
                    array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
                }
            }

        }else{
            foreach ($Player as $p){
                array_push($json, ['name' => $p['name'], 'uniqueId' => $p['uniqueId']]);
            }
        }
        return json_encode($json);
    }


    public function profile($uuid){
        $Player = DB::connection('mongodb_server')->collection('players')->where('uniqueId', $uuid)->first();

        if ($Player == null){
            return redirect('/');
        }

        $Sanctions = DB::connection('mongodb_server')->collection('punishments')
            ->where('punishedUuid', '=', $Player['uniqueId'])
            ->orderBy('timestamp', 'DESC')
            ->take(100)
            ->get();

        $Player['buy'] = DB::connection('mongodb')->collection('buy_logs')->where('uniqueId', $uuid)->orderby('date','DESC')->get();
        $Player['funds'] = DB::connection('mongodb')->collection('funds')->where('uniqueId', $uuid)->orderby('date','DESC')->get();
        $Player['shop'] = DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $uuid)->first();

        if ($Player['shop'] != null){
            $Player['shop'] = $Player['shop']['points'];
        }else{
            $Player['shop'] = 0;
        }

        $Player['online'] = true;

        $Logs = DB::connection('mongodb')->collection('profile_logs')->where('uniqueId', $Player['uniqueId'])->orderBy('data', 'ASC')->get();

        $ConnectionLogs = DB::connection('mongodb_server')->collection('connectionLogs')
            ->where('username', $Player['name'])
            ->orderBy('timestamp', -1)
            ->limit(10)
            ->get();

        $AvailablePermissions = DB::connection('mongodb_server')->collection('permissions')
            ->get();

        $Places = $this->getPlaces();

        try {
            $Guardian = DB::connection('mysql_guardian')->table('logs')->where('uuid', '=', $Player['uniqueId'])->orderBy("date", 'DESC')->limit(20)->get();
        }catch (\Exception $exception){
            $Guardian = [];
        }

        return view('users.view')
            ->with('Player', $Player)
            ->with('Sanctions', $Sanctions)
            ->with('Logs', $Logs)
            ->with('Guardian', $Guardian)
            ->with('ConnectionLogs', $ConnectionLogs)
            ->with('AvailablePermissions', $AvailablePermissions)
            ->with('Places', $Places);
    }

    private function getPlaces() {
        return [
            'bungee',
            'minigames',
            'pvpbox',
            'skyblock',
            'freebuild',
            'survie',
            'faction',
            'hub',
        ];
    }


}