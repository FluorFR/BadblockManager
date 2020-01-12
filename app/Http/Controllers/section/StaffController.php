<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\section;


use App\Models\Funds;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{


    public function index(){
        //Alternate group
        $alt = ['$or' =>
            [
                ['permissions.groups.bungee.superviseur' => ['$exists' => true]],
                ['permissions.groups.bungee.helper' => ['$exists' => true]],
                ['permissions.groups.bungee.admin' => ['$exists' => true]],
                ['permissions.groups.bungee.modo' => ['$exists' => true]],
                ['permissions.groups.bungee.supermodo' => ['$exists' => true]],
                ['permissions.groups.bungee.responsable' => ['$exists' => true]],
                ['permissions.groups.bungee.builder' => ['$exists' => true]],
                ['permissions.groups.bungee.animateur' => ['$exists' => true]],
                ['permissions.groups.bungee.modoforum' => ['$exists' => true]],
                ['permissions.groups.bungee.graphiste' => ['$exists' => true]],
                ['permissions.groups.bungee.redacteur' => ['$exists' => true]],
                ['permissions.groups.bungee.modocheat' => ['$exists' => true]],
                ['permissions.groups.bungee.manager' => ['$exists' => true]],
                ['permissions.groups.bungee.staff' => ['$exists' => true]]
            ]
        ];


        $data = DB::connection('mongodb_server')->collection('players')->where($alt)->orderby('permissions.group')->get();

        return view('section.staff')->with('user', $data);
    }


    public function connection(){

        //Alternate group
        $alt = ['$or' =>
            [
                ['permissions.groups.bungee.superviseur' => ['$exists' => true]],
                ['permissions.groups.bungee.helper' => ['$exists' => true]],
                ['permissions.groups.bungee.modo' => ['$exists' => true]],
                ['permissions.groups.bungee.supermodo' => ['$exists' => true]],
                ['permissions.groups.bungee.modocheat' => ['$exists' => true]],
                ['permissions.groups.bungee.modochat' => ['$exists' => true]]
            ]
        ];


        $Data = DB::connection('mongodb_server')->collection('players')->where($alt)->get();

        $Staff = [];

        foreach ($Data as $player){
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
                array_push($Staff, ['name' => $player['name'],'ntime' => $NTime,'time' => $Time, "PunishTime" => $PunishTime , 'Punish' => $Punish, 'grade' => $Grr]);
            }
        }

        usort($Staff, create_function('$a, $b', '
        $a = $a["time"];
        $b = $b["time"];

        if ($a == $b) return 0;

        $direction = strtolower(trim("desc"));

        return ($a ' . ("desc" == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
        '));

        return view('section.timestaff')->with('user', $Staff);
    }

}