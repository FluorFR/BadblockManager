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

class PaidController extends Controller
{


    public function index($section){

        $sections = ["forum","redaction","moderation","graphisme","animation","developpement","construction"];

        $ar_paid = ["32",'25',"12","13","27","26","24","4","29","8","14","33","10"];
        $ar_paidpb = ["4" => 1000,"32" => 1000,'25' => 800,"12" => 700,"27" => 700,"8" => 700,"26" => 700,"24" => 700,"14" => 700,"29" => 1000,"33" => 700,"10" => 1000];

        $group_rel = ["construction" => "33 OR user_group_id = 32","forum" => "8 OR user_group_id = 4","redaction" => 24,"moderation" => "25 OR user_group_id = 12 OR user_group_id = 10","graphisme" => 26,"animation" => "27 OR user_group_id = 29","developpement" => 14];

        if (in_array($section, $sections)){
            $result = DB::connection('mysql_forum')->select("select * from xf_user where user_group_id = " . $group_rel[$section] . " ORDER by username");
        }
        foreach ($result as $row){
            if (in_array($row->user_group_id, $ar_paid)){
                $row->pb = $ar_paidpb[$row->user_group_id];
            }else{
                $row->pb = 100;
            }
        }

        return view('section.paid', ['user' => $result,'name' => $section]);
    }

    public function save($section, Request $request){

        $sections = ["forum","redaction","moderation","graphisme","animation","developpement","construction"];

        $group_rel = ["construction" => "33 OR user_group_id = 32","forum" => "8 OR user_group_id = 4","redaction" => 24,"moderation" => "25 OR user_group_id = 12 OR user_group_id = 10","graphisme" => "26 OR user_group_id = 4","animation" => "27 OR user_group_id = 29","developpement" => 14];

        $logg = [];
        $pts= 0;

        if (in_array($section, $sections)){
            $result = DB::connection('mysql_forum')->select("select * from xf_user where user_group_id = " . $group_rel[$section]);
            //Foreach pour les paie
            foreach ($result as $row){
                if (!empty($request->input('pb_'. $row->user_id))){

                    $user = DB::connection('mongodb_server')->collection('players')->where('name', strtolower($row->username))->first();

                    $paie = DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $user['uniqueId'])->first();

                    if ($paie == null){
                        $data = [
                            "uniqueId" => $user['uniqueId'],
                            "points" => intval($request->input('pb_'. $row->user_id))
                        ];
                        DB::connection('mongodb')->collection('fund_list')->insert($data);
                    }else{
                        $paie = $paie['points'] + intval($request->input('pb_'. $row->user_id));
                        DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $user['uniqueId'])->update([
                            'points' => $paie
                        ]);
                    }

                    $pts = $pts + intval($request->input('pb_'. $row->user_id));

                    if ($user != null){
                        //Enregistrement de l'opération
                        $Funds = new Funds;
                        $Funds->uniqueId = $user['uniqueId'];
                        $Funds->points = intval($request->input('pb_'. $row->user_id));
                        $Funds->price = 0;
                        $Funds->pseudo = $row->username;
                        $Funds->gateway = "badblock";
                        $Funds->transaction_id = "Paie du " . date("Y-m") . " Commentaire : " . $request->input('comment_'. $row->user_id);
                        $Funds->date = date("Y-m-d h:i:s");
                        $Funds->save();
                    }

                    array_push($logg, ['Pseudo' => $row->username, 'points' => intval($request->input('pb_'. $row->user_id)), 'commentaire' => $request->input('comment_'. $row->user_id)]);
                }
            }
        }

        //Log to mongoDB
        DB::connection('mongodb')->collection('section_paid')->insert([
            'section' => $section,
            'total' => $pts,
            'date' => date("Y-m-d h:i:s"),
            'data' => $logg
        ]);

        return redirect('/');
    }

}