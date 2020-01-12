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
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class DockerController extends Controller
{
    public function index($ajax = false){

        //Connect to INT & Get data from json
        $All_clusters = Redis::connection('docker')->scan("0");
        $Data_cluster = [];
        foreach($All_clusters[1] as $Cluster){
            if (explode(":", $Cluster)[0] == "clusters"){
                $Cluster_Data = Redis::connection('docker')->get($Cluster);
                $Cluster_Data = json_decode($Cluster_Data);
                array_push($Data_cluster, ['name' => $Cluster, 'data' => $Cluster_Data]);
            }
        }


        //Push all instance type
        $Type_list = [];
        foreach ($Data_cluster as $Cluster){
            $Name = explode(":", $Cluster['name']);
            $Instances_type = DB::connection('mongodb_server')->collection('docker_' . strtolower($Name[1]))->get();
            foreach ($Instances_type as $Int){
                foreach ($Int['worlds'] as $world){
                    if (!in_array($world['name'], $Type_list)){
                        array_push($Type_list, $world['name']);
                    }
                }
            }
        }

        //Check all server running with this Type
        $Type_Server = [];
        foreach ($Type_list as $Type){
            foreach($All_clusters[1] as $Cluster){
                if (explode(":", $Cluster)[0] == "clusters"){
                    $Cluster_Data = Redis::connection('docker')->get($Cluster);
                    $Cluster_Data = json_decode($Cluster_Data);
                    foreach ($Cluster_Data->data->entities as $k => $T){
                        if ($k == $Type){
                            if (!isset($Type_Server[$Type])){
                                $Type_Server[$Type] = [];
                            }
                            foreach ($T as $s){
                                if (round(($s->lastKeepAlive / 1000), 0) >= time()){
                                    array_push($Type_Server[$Type], $s);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($ajax != false){
            return view('infra.instances')
                ->with('Clusters', $Data_cluster)
                ->with('Type_List', $Type_list)
                ->with('Servers', $Type_Server);
        }else{
            return view('infra.docker')
                ->with('Clusters', $Data_cluster)
                ->with('Type_List', $Type_list)
                ->with('Servers', $Type_Server);
        }

    }


    public function openInstance(){
        //TODO add cluster target

        $connection = new AMQPStreamConnection(getenv('RABBIT_IP'), getenv('RABBIT_PORT'), getenv('RABBIT_USERNAME'), getenv('RABBIT_PASSWORD'), getenv('RABBIT_VIRTUALHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('docker.instance.open_PROD', 'fanout', false, false, false, false);

        $InstanceOpenRequest = [
            "worldSystemName" => $_POST['WorldSystemName'],
            "owner" => $_POST['owner'],
            "target" => ""
        ];
        $SendRequest = [
            "expire" => -1,
            "message" => json_encode($InstanceOpenRequest)
        ];
        $msg = new AMQPMessage(json_encode($SendRequest));
        $channel->basic_publish($msg, '', 'docker.instance.open_PROD');

        return "ok";
    }

    public function closeInstance(){

        $connection = new AMQPStreamConnection(getenv('RABBIT_IP'), getenv('RABBIT_PORT'), getenv('RABBIT_USERNAME'), getenv('RABBIT_PASSWORD'), getenv('RABBIT_VIRTUALHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('docker.instance.stop', 'fanout', false, false, false, false);

        $SendRequest = [
            "expire" => -1,
            "message" => $_POST['InstanceName']
        ];
        $msg = new AMQPMessage(json_encode($SendRequest));
        $channel->basic_publish($msg, '', 'docker.instance.stop');

        return "ok close";

    }


}