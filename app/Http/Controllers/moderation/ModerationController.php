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

class ModerationController extends Controller
{

    public function index(){

        return view('section.mod.moderation');

    }

    public function screen(){
        $Screen = DB::connection('mongodb')->collection('log_upload')->where('user', '=', strtolower(Auth::user()->name))->orderBy('date', 'DESC')->take(10)->get();

        return json_encode($Screen);
    }

    public function sanction(){
        $Sanctions = DB::connection('mongodb_server')->collection('punishments')
            ->where('punisher', '=', strtolower(Auth::user()->name))
            ->where('proof', '=', [])
            ->where(function ($query) {
                $query->where('type', '=', "MUTE")
                    ->orWhere('type', '=', "KICK")
                    ->orWhere('type', '=', "UNBAN")
                    ->orWhere('type', '=', "BAN")
                    ->orWhere('type', '=', "WARN");
            })
            ->orderBy('timestamp', 'DESC')
            ->take(1000)
            ->get()
            ->toArray();

        foreach ($Sanctions as $k => $san){
            $user = DB::connection('mongodb_server')->collection('players')->where('uniqueId' ,'=', $san['punishedUuid'])->first();
            $Sanctions[$k]['pseudo'] = $user['name'];
        }

        return json_encode($Sanctions);
    }

    public function union(){


        $Screens = json_decode($_POST["screens"]);
        $Parse_Src = [];

        foreach ($Screens as $src){
            $Img = DB::connection('mongodb')->collection('log_upload')->find($src);
            if ($Img != null){
                array_push($Parse_Src, $Img);
            }
        }

        $Insert = [
            'sanction_id' => $_POST['sanc_id'],
            'date' => date('Y-m-d H:i:s'),
            'screens' => $Parse_Src,
            'note' => $_POST['notes']
        ];

        DB::connection('mongodb')->collection('sanctions')->insert($Insert);


        $Id = DB::connection('mongodb')->collection('sanctions')->where('sanction_id','=', $_POST['sanc_id'])->first();

        DB::connection('mongodb_server')->collection('punishments')
            ->where('uuid', '=', $_POST['sanc_id'])
            ->update([
                'proof' => $Id['_id']
            ]);


        return "[]";

    }

    public function share(){
        //POST rename
        $Username = strtolower($_POST['username']);
        $Screens = json_decode($_POST["screens"]);

        //Parse screen after duplicate
        $Parse_Src = [];
        foreach ($Screens as $src){
            $Img = DB::connection('mongodb')->collection('log_upload')->find($src);
            if ($Img != null){
                array_push($Parse_Src, $Img);
                //Save dans MongoDB
                $data = [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'user' => strtolower($Username),
                    'date' => date("Y-m-d H:i:s"),
                    'file_name' => $Img['file_name'],
                    'shared' => true,
                ];
                DB::connection('mongodb')->collection('log_upload')->insert($data);
            }
        }

        return "[]";
    }

}