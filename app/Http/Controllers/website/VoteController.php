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


class VoteController extends Controller
{

    public function index(){
        $date = new \DateTime(date("Y-m-d"));

        if ($date->format('d') == "1"){
            $date = date("Y-m", strtotime("-1 months"));
        }else{
            $date = date("Y-m");
        }

        //Search data
        $data = DB::connection('mongodb')->collection('stats_vote')->where('date', $date)->first();

        if ($data['give'] == true){
            return redirect('/');
        }

        //Lecture du classement
        $data = (array) $data['players'];
        usort($data, create_function('$a, $b', '
        $a = $a["vote"];
        $b = $b["vote"];

        if ($a == $b) return 0;

        $direction = strtolower(trim("desc"));

        return ($a ' . ("desc" == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
        '));

        $data = array_slice($data, 0, 30);

        foreach ($data as $k => $row){
            if ($k == 0){
                $data[$k]['pb'] = 3000;
            }elseif ($k == 1){
                $data[$k]['pb'] = 2250;
            }elseif ($k == 2){
                $data[$k]['pb'] = 2000;
            }elseif ($k < 6){
                $data[$k]['pb'] = 1500;
            }elseif ($k < 10){
                $data[$k]['pb'] = 750;
            }elseif ($k < 20){
                $data[$k]['pb'] = 625;
            }else{
                $data[$k]['pb'] = 250;
            }
        }

        return view('website.vote')->with('data', $data);
    }


    public function save(){

        $logg = [];

        foreach ($_POST['list'] as $k => $row){
            $user = DB::connection('mongodb_server')->collection('players')->where('name', strtolower($row))->first();
            $paie = DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $user['uniqueId'])->first();
            $pb = $_POST['pb'][$k];
            if ($paie == null){
                $data = [
                    "uniqueId" => $user['uniqueId'],
                    "points" => intval($pb)
                ];
                DB::connection('mongodb')->collection('fund_list')->insert($data);
            }else{
                $paie = $paie['points'] + intval($pb);
                DB::connection('mongodb')->collection('fund_list')->where('uniqueId', $user['uniqueId'])->update([
                    'points' => $paie
                ]);
            }
            array_push($logg, ['Pseudo' => $row, 'points' => intval($pb)]);
        }




        //Log to mongoDB
        DB::connection('mongodb')->collection('vote_paid')->insert([
            'date' => date("Y-m-d h:i:s"),
            'data' => $logg
        ]);

        return redirect('/');
    }

    public function down(){
        //Search mongoDB data

        $date = new \DateTime(date("Y-m-d", strtotime("last day of previous month")));

        //Search data
        $data = DB::connection('mongodb')->collection('stats_vote')->where('date', $date->format('Y-m'))->first();

        if ($data['give'] == true){
            return redirect('/');
        }

        //Lecture du classement
        $data = (array) $data['players'];
        usort($data, create_function('$a, $b', '
        $a = $a["vote"];
        $b = $b["vote"];

        if ($a == $b) return 0;

        $direction = strtolower(trim("desc"));

        return ($a ' . ("desc" == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
        '));

        $data = array_slice($data, 0, 30);

        foreach ($data as $k => $row){
            if ($k == 0){
                $data[$k]['pb'] = 3000;
            }elseif ($k == 1){
                $data[$k]['pb'] = 2250;
            }elseif ($k == 2){
                $data[$k]['pb'] = 2000;
            }elseif ($k < 6){
                $data[$k]['pb'] = 1500;
            }elseif ($k < 10){
                $data[$k]['pb'] = 750;
            }elseif ($k < 20){
                $data[$k]['pb'] = 625;
            }else{
                $data[$k]['pb'] = 250;
            }
        }


        $array = Array (
            0 => Array (
                0 => "Votes BadBlock "
            ),
            1 => Array (
                0 => "Pseudo",
                1 => "Points"
            )
        );
        foreach ($data as $row){
            array_push($array, [$row['name'],$row['pb']]);
        }

        $date = date("Y-m");


        header("Content-Disposition: attachment; filename=\"badblock-vote-" . $date .".xls\"");
        header("Content-Type: application/vnd.ms-excel;");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = fopen("php://output", 'w');
        foreach ($array as $data)
        {
            fputcsv($out, $data,"\t");
        }
        fclose($out);



    }


}