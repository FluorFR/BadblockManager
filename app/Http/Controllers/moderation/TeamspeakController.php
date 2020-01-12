<?php

namespace App\Http\Controllers\moderation;

use Adams\TeamSpeak3;
use App\Http\Controllers\Controller;


class TeamspeakController extends Controller
{
    /**
     * Show clients connected to TeamSpeak 3 server.
     *
     * @return Response
     */

    public function banList()
    {
        $query = app()->make(TeamSpeak3::class);

        $data = $query->banList();

        foreach ($data as $k => $item) {
            $seconds = $item['duration'];
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds / 60) % 60);
            $seconds = $seconds % 60;
            $data[$k]['duration'] = "$hours:$minutes:$seconds";
        }

        return view('teamspeak.banlist')->with('ban', $data);

    }
}