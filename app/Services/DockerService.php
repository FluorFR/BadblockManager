<?php
/**
 * Created by IntelliJ IDEA.
 * User: Theo
 * Date: 05/02/2019
 * Time: 19:57
 */

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class DockerService {

    private $channel;

    public function __construct()
    {
        try {
            $connection = new AMQPStreamConnection(
                env('RABBIT_IP'),
                env('RABBIT_PORT'),
                env('RABBIT_USERNAME'),
                env('RABBIT_PASSWORD'),
                env('RABBIT_VIRTUALHOST')
            );
            $this->channel = $connection->channel();
        } catch(\Exception $e) {
            $this->channel = null;
        }
    }

    public function isConnected() {
        return $this->channel !== null;
    }

    public function publishData($queue , $message){
        $this->channel->exchange_declare($queue, 'fanout', false, false, false, false);

        $obj = (object)[
            'expire' => (time() + 604800) * 1000,
            'message' => json_encode($message)
        ];

        $msg = new AMQPMessage(json_encode($obj));
        $this->channel->basic_publish($msg, $queue);

        return true;
    }

    public function sendData($queue , $message){
        $this->channel->queue_declare($queue, false, false, false, false);

        $obj = (object)[
            'expire' => (time() + 604800) * 1000,
            'message' => json_encode($message)
        ];

        $msg = new AMQPMessage(json_encode($obj));
        $this->channel->basic_publish($msg, '', $queue);

        return true;
    }



    public function sendPrivateMessage($Username, $message){
        $message = str_replace("&", "ยง", $message);
        $Object = [
            'playerName' => $Username,
            'type' => "SEND_MESSAGE",
            'content' => $message
        ];

        $this->publishData("bungee.processing.players.linkQueue", $Object);
    }

    public function broadcast($message){
        $message = str_replace("&", "ยง", $message);
        $Object = [
            'type' => "BROADCAST",
            'content' => $message
        ];

        $this->publishData("bungee.processing.bungee.linkQueue", $Object);
    }

    public function kickPlayer($Username, $Reason){
        $Object = [
            'playerName' => $Username,
            'type' => "KICK",
            'content' => $Reason
        ];

        $this->publishData("bungee.processing.players.linkQueue", $Object);
    }

    public function banPlayer($Username, $Reason, $Time){
        $message = [
            'punishmentType' => "BAN",
            'playerName' => $Username,
            'reason' => $Reason,
            'isKey' => false,
            'time' => $Time
        ];

        $this->sendData('bungee.punishment', $message);
    }

    public function mutePlayer($Username, $Reason, $Time){
        $message = [
            'punishmentType' => "MUTE",
            'playerName' => $Username,
            'reason' => $Reason,
            'isKey' => true,
            'time' => $Time
        ];

        $this->sendData('bungee.punishment', $message);
    }

    public function warnPlayer($Username, $Reason){
        $message = [
            'punishmentType' => "WARN",
            'playerName' => $Username,
            'reason' => $Reason,
            'isKey' => true
        ];

        $this->sendData('bungee.punishment', $message);
    }
}