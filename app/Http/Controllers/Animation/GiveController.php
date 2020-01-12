<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\Animation;


use App\Models\Funds;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiveController extends Controller
{

    public function points(){

        return view('animation.points');

    }

    public function item(){
        $item = DB::connection('mongodb')->collection('product_list')->get();

        return view('animation.item', ['item' => $item]);
    }

    public function savepoints(){

        $logg = [];

        foreach ($_POST['pseudo'] as $k => $row){
            if (!empty($row)){

                $user = DB::connection('mongodb_server')->collection('players')->where('name', strtolower($row))->first();
                $paie = DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $user['uniqueId'])->first();

                if ($paie == null){
                    $data = [
                        "uniqueId" => $user['uniqueId'],
                        "points" => intval($_POST['points'][$k])
                    ];
                    DB::connection('mongodb')->collection('fund_list')->insert($data);
                }else{
                    $paie = $paie['points'] + intval($_POST['points'][$k]);
                    DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $user['uniqueId'])->update([
                        'points' => $paie
                    ]);
                }

                if ($user != null){
                    //Enregistrement de l'opération
                    $Funds = new Funds;
                    $Funds->uniqueId = $user['uniqueId'];
                    $Funds->points = intval($_POST['points'][$k]);
                    $Funds->price = 0;
                    $Funds->pseudo = $row;
                    $Funds->gateway = "badblock";
                    $Funds->transaction_id = "Gain animation du " . date("Y-m") . " ceci n'est pas une facture";
                    $Funds->date = date("Y-m-d h:i:s");
                    $Funds->save();
                }

                array_push($logg, ['Pseudo' => $row, 'points' => intval($_POST['points'][$k])]);
            }
        }


        //Log to mongoDB
        DB::connection('mongodb')->collection('animation_paid')->insert([
            'date' => date("Y-m-d h:i:s"),
            'user_id' => Auth::user()->id,
            'data' => $logg
        ]);

        return redirect('/animation/pb');
    }

    public function saveitem()
    {
        $logg = [];

        foreach ($_POST['pseudo'] as $k => $row) {
            if (!empty($row)){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://badblock.fr/shop/achat/" . $_POST['give'][$k]);
                curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; BadBlock/1.0; +https://badblock.fr/)');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,
                    http_build_query(array('playerName' => $row, 'animation' => "oui")));

                $server_output = curl_exec($ch);

                curl_close ($ch);
                if ($server_output){
                    array_push($logg, ['Pseudo' => $row, 'items' => $_POST['give'][$k]]);
                }
            }
        }

        //Log to mongoDB
        DB::connection('mongodb')->collection('animation_paid')->insert([
            'date' => date("Y-m-d h:i:s"),
            'data' => $logg
        ]);

        return redirect('/animation/item');

    }
}