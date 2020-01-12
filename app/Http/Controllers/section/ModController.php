<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\section;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\RequestInterface;

class ModController extends Controller
{


    public function preuves(){

        $Sanctions = DB::connection('mongodb_server')->collection('punishments')
            ->where('proof', '=', [])
            ->where('punisher', '!=', "Console")
            ->where(function ($query) {
                $query->where('type', '=', "MUTE")
                    ->orWhere('type', '=', "KICK")
                    ->orWhere('type', '=', "UNBAN")
                    ->orWhere('type', '=', "BAN")
                    ->orWhere('type', '=', "WARN");
            })
            ->orderBy('timestamp', 'DESC')
            ->take(200)
            ->get()
            ->toArray();


        return view('section.mod.nopreuve', ['Sanctions' => $Sanctions]);

    }

    public function notif() {

        DB::table('notifications')->insert([
            'user_id' => NotificationsController::convertPseudoId($_POST['banner']),
            'title' => "Preuve(s) !",
            'link' => '/moderation',
            'icon' => 'https://image.flaticon.com/icons/svg/179/179386.svg',
            'text' => 'Oublie de preuve. Merci de corriger.',
            'active' => 1
        ]);

    }

}