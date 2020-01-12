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

class BuildController extends Controller
{


    public function index(){
        $Top = DB::connection('mysql_casier')
            ->table('builderSessions')
            ->select(
                DB::raw("SUM(loginTime) as login"),
                "username",
                DB::raw("SUM(placedBlocks) as placedBlocks"),
                DB::raw("SUM(brokenBlocks) as brokenBlocks"),
                DB::raw("SUM(commands) as commands")
            )
            ->where('date', '>=', date('Y-m'))
            ->groupBy('username')
            ->orderBy('login', 'DESC')
            ->get();





        return view('section.build.session')->with('Top', $Top);
    }

}