<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\section;


use App\Models\Funds;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TfaController extends Controller
{


    public function index(){
        //Alternate group
        $alt = ['$or' =>
            [
                ['permissions.groups.bungee.superviseur' => ['$exists' => true]],
                ['permissions.groups.bungee.helper' => ['$exists' => true]],
                ['permissions.groups.bungee.admin' => ['$exists' => true]],
                ['permissions.groups.bungee.modo' => ['$exists' => true]],
                ['permissions.groups.bungee.supermodo' => ['$exists' => true]],
                ['permissions.groups.bungee.responsable' => ['$exists' => true]],
                ['permissions.groups.bungee.builder' => ['$exists' => true]],
                ['permissions.groups.bungee.animateur' => ['$exists' => true]],
                ['permissions.alternateGroups.modoforum' => ['$exists' => true]],
                ['permissions.alternateGroups.graphiste' => ['$exists' => true]],
                ['permissions.alternateGroups.redacteur' => ['$exists' => true]],
                ['permissions.alternateGroups.modocheat' => ['$exists' => true]],
                ['permissions.alternateGroups.manager' => ['$exists' => true]],
                ['permissions.alternateGroups.staff' => ['$exists' => true]]
            ]
        ];


        $data = DB::connection('mongodb_server')->collection('players')->where($alt)->orderby('permissions.group')->get();

        return view('section.tfa')->with('user', $data);
    }

}