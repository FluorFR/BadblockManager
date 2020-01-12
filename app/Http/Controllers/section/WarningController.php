<?php

/**
 * Created by Atom.
 * User: Hooki
 * Date: 05/01/2019
 * Time: 22:14
 */

namespace App\Http\Controllers\section;

use App\Http\Controllers\Controller as Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\section\NotificationsController;

class WarningController extends Controller
{

    public static function convertTime($date)
    {
        $DateTime = date_create($date);
        return date_format($DateTime, 'd/m/Y à H:i:s');
    }

    public function index()
    {

        return view('section.warning.send_warning');

    }

    public function list()
    {
        return view('section.warning.list');
    }

    public function display($id)
    {

        $user = DB::table('warning')->where('id', '=', $id)->get();
        if ($user[0]->pseudo == Auth::user()->name) {
            return view('section.warning.display', ['user' => $user]);
        } else {
            return redirect('/');
        }

    }

    public function delete($id)
    {
        DB::table('warning')->where('id', '=', $id)->delete();
        return redirect('/section/avertissement-list');
    }

    public function send(Request $request)
    {

        DB::table('warning')->insert([

            'warn_by' => $request->input('warn_by'),
            'pseudo' => $request->input('pseudo'),
            'title' => $request->input('title'),
            'text' => $request->input('text')

        ]);


        DB::table('notifications')->insert([
            'user_id' => NotificationsController::convertPseudoId($request->input('pseudo')),
            'title' => $request->input('title'),
            'link' => '/avertissement/' . DB::table('warning')->max('id'),
            'icon' => 'https://image.flaticon.com/icons/svg/179/179386.svg',
            'text' => 'Vous venez de recevoir un avertissement.'
        ]);


        return redirect('/section/avertissement-list');

    }

}
