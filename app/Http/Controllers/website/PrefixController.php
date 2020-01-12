<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\website;


use App\Models\Funds;
use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class PrefixController extends Controller
{

    public function index(){
        //Search data
        $data = DB::connection('mongodb_server')->collection('custom_data')->where('prefix_state', false)->where('prefix_new', '!=', "")->get();

        return view('website.prefix')->with('data', $data);
    }

    public function save(){
        foreach ($_POST['list'] as $k => $row){
            if ($_POST['val'][$k] == "true"){
                DB::connection('mongodb_server')->collection('custom_data')->where('uniqueId', $row)->update([
                    'prefix' => $_POST['prefix'][$k],
                    'prefix_state' => true,
                    'prefix_new' => ""
                ]);
            }elseif ($_POST['val'][$k] == "refused"){
                DB::connection('mongodb_server')->collection('custom_data')->where('uniqueId', $row)->update([
                    'prefix_state' => "refused"
                ]);
            }
        }

        //Discord WebHook notif

        $data = array("username" => "Grade Custom","embeds" => array(0 => array(
            "url" => "http://badblock.fr",
            "title" => "Manager",
            "description" => "Tout les préfix sont validés !",
            "color" => 5788507
        )));

        $curl = curl_init(env('DISCORD_RESP'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);


        return redirect('/website/prefix');
    }

}