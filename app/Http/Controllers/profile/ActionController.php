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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Operation;
use App\Models\Product;
use Illuminate\Support\Facades\Response;


class ActionController extends Controller
{


    public function resetPassword($uuid){
        $Player = DB::connection('mongodb_server')->collection('players')->where('uniqueId', $uuid)->first();

        $check = false;
        foreach ($Player['permissions']['groups']['bungee'] as $k => $row) {
            if ($k != "default" && $k != "vip" && $k != "vip+" && $k != "mvp" && $k != "mvp+" && $k != "gradeperso" && $k != "noel") {
                $check = true;
            }
        }

        if ($check){
            $returnData = array(
                'status' => 'error',
                'message' => 'An error occurred!'
            );
            return Response::json($returnData, 500);
        }

        $Player['loginPassword'] = "";
        unset($Player['_id']);

        DB::connection('mongodb')->collection('profile_logs')->insert([
            'date' => date('Y-m-d H:i:s'),
            'action' => "Password reset !",
            'uniqueId' => $uuid,
            'user' => Auth::user()->name
        ]);

        DB::connection('mongodb_server')->collection('players')->where('name', $Player['name'])->update($Player);
    }

    public function resetTfa($uuid){
        $Player = DB::connection('mongodb_server')->collection('players')->where('uniqueId', $uuid)->first();

        $check = false;
        foreach ($Player['permissions']['groups']['bungee'] as $k => $row) {
            if ($k != "default" && $k != "vip" && $k != "vip+" && $k != "mvp" && $k != "mvp+" && $k != "gradeperso" && $k != "noel") {
                $check = true;
            }
        }

        if ($check){
            $returnData = array(
                'status' => 'error',
                'message' => 'An error occurred!'
            );
            return Response::json($returnData, 500);
        }

        unset($Player['_id']);
        $Player['authKey'] = "";

        DB::connection('mongodb_server')->collection('players')->where('name', $Player['name'])->update($Player);

        DB::connection('mongodb')->collection('profile_logs')->insert([
            'date' => date('Y-m-d H:i:s'),
            'action' => "TFA reset",
            'uniqueId' => $uuid,
            'user' => Auth::user()->name
        ]);

        return "OK";
    }

    public function resetOm($uuid){
        $Player = DB::connection('mongodb_server')->collection('players')->where('uniqueId', $uuid)->first();


        $check = false;
        foreach ($Player['permissions']['groups']['bungee'] as $k => $row) {
            if ($k != "default" && $k != "vip" && $k != "vip+" && $k != "mvp" && $k != "mvp+" && $k != "gradeperso" && $k != "noel") {
                $check = true;
            }
        }

        if ($check){
            $returnData = array(
                'status' => 'error',
                'message' => 'An error occurred!'
            );
            return Response::json($returnData, 500);
        }

        $Player['onlineMode'] = false;
        unset($Player['_id']);
        DB::connection('mongodb_server')->collection('players')->where('name', $Player['name'])->update($Player);

        DB::connection('mongodb')->collection('profile_logs')->insert([
            'date' => date('Y-m-d H:i:s'),
            'action' => "Actived offline mode",
            'uniqueId' => $uuid,
            'user' => Auth::user()->name
        ]);

        return "OK";
    }

    public function resetOl($uuid){
        $Player = DB::connection('mongodb_server')->collection('players')->where('uniqueId', $uuid)->first();


        $check = false;
        foreach ($Player['permissions']['groups']['bungee'] as $k => $row) {
            if ($k != "default" && $k != "vip" && $k != "vip+" && $k != "mvp" && $k != "mvp+" && $k != "gradeperso" && $k != "noel") {
                $check = true;
            }
        }

        if ($check){
            $returnData = array(
                'status' => 'error',
                'message' => 'An error occurred!'
            );
            return Response::json($returnData, 500);
        }

        $Player['onlineMode'] = true;
        unset($Player['_id']);
        DB::connection('mongodb_server')->collection('players')->where('name', $Player['name'])->update($Player);

        DB::connection('mongodb')->collection('profile_logs')->insert([
            'date' => date('Y-m-d H:i:s'),
            'action' => "Actived online mode",
            'uniqueId' => $uuid,
            'user' => Auth::user()->name
        ]);

        return "OK";
    }

    public function addGroup(Request $request, $uuid) {
        $Player = DB::connection('mongodb_server')->collection('players')->where('uniqueId', $uuid)->first();
        $groupName = $request->get('groupName');

        $data = $request->all();
        $place = $data['place'];
        $group = $data['group'];
        $expire = $data['expire'];

        // set expire timestamp
        if(preg_match('/[0-9]{4}(-[0-9]{2}){2}/', $expire)) {
            $expire = strtotime($expire) * 1000; // *1000 because MongoDB uses millis. timestamps
        } else {
            $expire = -1;
        }

        // if the place had no groups, create the array first
        if(!isset($Player['permissions']['groups'][$place])) {
            $Player['permissions']['groups'][$place] = [];
        }

        // add the group
        $Player['permissions']['groups'][$place][$group] = $expire;

        // update the collection
        DB::connection('mongodb_server')->collection('players')->where('name', $Player['name'])->update($Player);

        // Create profile log entry
        DB::connection('mongodb')->collection('profile_logs')->insert([
            'date' => date('Y-m-d H:i:s'),
            'action' => "Added group <" . $groupName  . "> to user",
            'uniqueId' => $uuid,
            'user' => Auth::user()->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Groupe ajouté'
        ]);
    }

}