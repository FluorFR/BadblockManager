<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 18/02/2019
 * Time: 12:39
 */

namespace App\Http\Controllers\Infra;


use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

class McController extends Controller
{

    public function players(){
        $Cache = Redis::get('api.mc.players');
        if ($Cache != null){
            return json_encode(["players" => ['now' => intval($Cache)]]);
        }else{
            try
            {
                $Query = new MinecraftPing( 'play.badblock.fr', 25565 );
                $online = $Query->Query()["players"]["online"];

                if (intval($online) != 0 && intval($online) != null){
                    Redis::set('api.mc.players', $online);
                    Redis::expire('api.mc.players', 5);
                }else{
                    $online = file_get_contents('https://minecraft-api.com/api/ping/playeronline.php?ip=play.badblock.fr&port=25565');
                    Redis::set('api.mc.players', intval($online));
                    Redis::expire('api.mc.players', 5);
                }

                return json_encode(["players" => ['now' => $online]]);
            }
            catch( MinecraftPingException $e )
            {
                //
            }
            finally
            {
                if( $Query )
                {
                    $Query->Close();
                }
            }
        }

    }


    public function ban(){

        $Cache = Redis::get('api.mc.ban');
        if ($Cache != null){
            return json_encode(["players" => ['now' => intval($Cache)]]);
        }else{
            $Data = DB::connection('mongodb_server')->collection('players')->where('punish.ban.expire', '>', time() * 1000)->count();
            Redis::set('api.mc.ban', intval($Data));
            Redis::expire('api.mc.ban', 30);
            return json_encode(["players" => ['now' => intval($Data)]]);
        }
    }

}