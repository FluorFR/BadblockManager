<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\moderation;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CasierController extends Controller
{
    public function case($pseudo){
        $Sanctions = DB::connection('mongodb_server')->collection('punishments')
            ->where('punishedUuid', '=', $pseudo)
            ->orderBy('timestamp', 'DESC')
            ->take(100)
            ->get();

        $pseudo = DB::connection('mongodb_server')->collection('players')
            ->where('uniqueId', '=', $pseudo)
            ->first()['name'];

        return view('section.mod.casier', ['pseudo' => $pseudo, 'sanction' => $Sanctions]);
    }

    public function minicase($pseudo){
        $pseudo = DB::connection('mongodb_server')->collection('players')
            ->where('name', '=', $pseudo)
            ->first();

        $Sanctions = DB::connection('mongodb_server')->collection('punishments')
            ->where('punishedUuid', '=', $pseudo['uniqueId'])
            ->orderBy('timestamp', 'DESC')
            ->take(100)
            ->get();

        return view('section.mod.minicasier', ['pseudo' => $pseudo['name'], 'sanction' => $Sanctions]);
    }

    public function preuve($id){
        $Preuve = DB::connection('mongodb')->collection('sanctions')->where('_id', '=', $id)->first();

        return view('section.mod.preuve', ['data' => $Preuve]);

    }

}