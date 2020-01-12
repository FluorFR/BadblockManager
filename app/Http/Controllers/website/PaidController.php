<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\website;


use App\Models\Funds;
use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class PaidController extends Controller
{

    public function index(){

        //Search data
        $data = DB::connection('mongodb')->collection('section_paid')->orderBy('date', 'DESC')->get();

        $sec = ["forum","redaction","moderation","graphisme","animation","developpement","construction"];

        return view('website.section')->with('data', $data)->with('sec', $sec);
    }

    public function view($uuid){

        //Search data
        $data = DB::connection('mongodb')->collection('section_paid')->where('_id', '=', $uuid)->first();

        return view('website.section-view')->with('data', $data);
    }

}