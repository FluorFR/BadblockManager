<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\Infra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;



class MongoDBController extends Controller
{
    public function index(){

        return view('infra.mongodb');

    }

    public function mongoStat(){

        try {
            $database = (new \MongoDB\Client(
                'mongodb://'.$_ENV['MONGO_SERVER_USERNAME'].":".$_ENV['MONGO_SERVER_PASSWORD']."@".$_ENV['MONGO_SERVER_HOST'].":".$_ENV['MONGO_SERVER_PORT']	."/".$_ENV['MONGO_SERVER_DATABASE']
            ))->admin;

            $cursor = $database->command(['serverStatus' => 1]);
            $data = $cursor->toArray()[0];
            //Uptime
            $timeFormat = gmdate("H:i:s", $data['uptime']);
            //Average response
            $ms = $data['connections']['current'];

            $json = ["on" => $data['ok'],"ms" => $ms,"uptime" => $timeFormat];

            return json_encode($json);

        }catch (\MongoConnectionException $e){
            $json = ["on" => 0,"ms" => 0,"uptime" => 0,"load" => 0];

            return json_encode($json);
        }


    }


}