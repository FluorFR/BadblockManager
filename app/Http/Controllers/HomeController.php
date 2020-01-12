<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Check personal stats
        $Stats = Redis::get('stats:user:' . Auth::user()->id);
        if ($Stats != null){
            return view('home')->with('stats', (array) json_decode($Stats));
        }

        $player = DB::connection('mongodb_server')->collection('players')->where("name", "=", strtolower(Auth::user()->name))->first();

        $Time = DB::connection('mongodb_server')
            ->collection('modoSessions')
            ->where('timestamp', '>=', strtotime(date('Y-m')) * 1000)
            ->where('playerUuid', '=', $player['uniqueId'])
            ->sum('totalTime');
        $Punish = DB::connection('mongodb_server')
            ->collection('modoSessions')
            ->where('timestamp', '>=', strtotime(date('Y-m')) * 1000)
            ->where('playerUuid', '=', $player['uniqueId'])
            ->sum('punishments');
        $PunishTime = DB::connection('mongodb_server')
            ->collection('modoSessions')
            ->where('timestamp', '>=', strtotime(date('Y-m')) * 1000)
            ->where('playerUuid', '=', $player['uniqueId'])
            ->sum('punishmentTime');

        $Detect = false;
        $Grades = ['supermodo', 'modocheat','modo', 'modochat', 'helper'];
        $LTime = [45, 40,40, 35, 25];

        foreach ($Grades as $k => $G){
            if (!$Detect){
                if (isset($player['permissions']['groups']['bungee'][$G])){
                    $Grr = $G;
                    $NTime = $LTime[$k];
                    $Detect = true;
                }
            }
        }
        if ($Time == 0){
            $Time = 1;
        }


        if (isset($Grr)){
            $Stats['name'] = $player['name'];
            $Stats['ntime'] = $NTime;
            $Stats['time'] = $Time;
            $Stats['PunishTime'] = $PunishTime;
            $Stats['Punish'] = $Punish;
            $Stats['grade'] = $Grr;
        }else{
            $Stats['name'] = $player['name'];
            $Stats['ntime'] = 1;
            $Stats['time'] = $Time;
            $Stats['PunishTime'] = 1;
            $Stats['Punish'] = 1;
            $Stats['grade'] = 'N/A';
        }

        Redis::set('stats:user:' . Auth::user()->id, json_encode($Stats));
        Redis::expire('stats:user:' . Auth::user()->id, 500);

        return view('home')->with('stats', $Stats);
    }
}
