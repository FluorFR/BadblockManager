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
use App\Models\Product;


class IndexController extends Controller
{
    public function index(){

        $period = new \DatePeriod(
            new \DateTime(date("y-m-d", strtotime("-1 month"))),
            new \DateInterval('P1D'),
            new \DateTime(date("y-m-d", strtotime("+1 days")))
        );
        $revenu_chart = [];
        foreach ($period as $date){
            $date1 = $date;
            $data = Funds::where('date', 'like', '%'. $date->format("Y-m-d") .'%')->sum('price');
            $date2 = $date->sub(new \DateInterval('P1M'));
            $data2 = Funds::where('date', 'like', '%'. $date->format("Y-m-d") .'%')->sum('price');
            array_push($revenu_chart, ["date" => $date->format("Y-m-d"),"result" => $data,"result_last" => $data2]);
        }

        $operation_chart = [];
        foreach ($period as $date){
            $date1 = $date;
            $data = Operation::where('date', 'like', '%'. $date->format("Y-m-d") .'%')->sum('price');
            $date2 = $date->sub(new \DateInterval('P1M'));
            $data2 = Operation::where('date', 'like', '%'. $date->format("Y-m-d") .'%')->sum('price');
            array_push($operation_chart, ["date" => $date->format("Y-m-d"),"result" => $data,"result_last" => $data2]);
        }


        //décaissement du jour
        $decai_day = Operation::where('date', 'like', '%'. date("Y-m-d") .'%')->sum('price');
        $decai_last = Operation::where('date', 'like', '%'. date("Y-m-d", strtotime("-1 days")) .'%')->sum('price');

        //décaissement du moi
        $decai_month = Operation::where('date', 'like', '%'. date("Y-m") .'%')->sum('price');
        $decai_mlast = Operation::where('date', 'like', '%'. date("Y-m", strtotime("-1 month")) .'%')->sum('price');

        //CA du moi
        $ca_month = Funds::where('date', 'like', '%'. date("Y-m") .'%')->sum('price');

        //CA du jour
        $ca_day = Funds::where('date', 'like', '%'. date("Y-m-d") .'%')->sum('price');

        $data = [
            "ca_m" => $ca_month,
            "ca_d" => $ca_day,
            "dec_d_last" => $decai_last,
            "dec_d" => $decai_day,
            "dec_m_last" => $decai_mlast,
            "dec_m" => $decai_month,
            "ca_chart" => $revenu_chart,
            "op_chart" => $operation_chart
        ];

        foreach ($data as $key => $row){
            if ($row == 0){
                $data[$key] = 1;
            }
        }

        return view('website.index')->with('data', $data);
    }


    public function compta($date = null){

        //Search mongoDB data
        if ($date == null){
            $date = date("Y-m");
        }
        $data = Funds::where('date', 'like', '%'. $date .'%')->get();


        $array = Array (
            0 => Array (
                0 => "Rechargement BadBlock *"
            ),
            1 => Array (
                0 => "Mode",
                1 => "Date",
                2 => "Pseudo",
                3 => "Prix"
            )
        );
        foreach ($data as $row){
            array_push($array, [$row->gateway,$row->date,$row->pseudo,$row->price]);
        }

        header("Content-Disposition: attachment; filename=\"badblock-compta-" . $date .".xls\"");
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

    public function registre(){


    }


}