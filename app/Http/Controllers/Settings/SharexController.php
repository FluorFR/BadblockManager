<?php

namespace App\Http\Controllers\Settings;

use App\Models\ShareX;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SharexController extends Controller
{


    public function index()
    {

        $Data = DB::table('shareX')->where('user_id', '=', Auth::user()->id)->first();

        if ($Data == null){
            //New ShareX
            $this->new();
        }


        return view('Settings.sharex')->with('data',$Data);
    }

    public function new(){

        DB::table('shareX')->where('user_id', '=', Auth::user()->id)->delete();

        $Insert = [
            'user_id' => Auth::user()->id,
            'token' => bin2hex(random_bytes(30)),
            'last_used' => date("Y-m-d h:i:s"),
            'last_ip' => 'N/A'
        ];

        DB::table('shareX')->insert($Insert);

        return $this->index();
    }


    public function down(){

        $Data = DB::table('shareX')->where('user_id', '=', Auth::user()->id)->first();

        $json = [
            'Name' => "cdn.badblock.fr",
            'DestinationType' => "ImageUploader",
            'RequestType' => "POST",
            'RequestURL' => "https://manager.badblock.fr/api/upload",
            'FileFormName' => 'image',
            'Arguments' => [
                'token' => $Data->token
            ],
            "ResponseType" => "RedirectionURL"
        ];

        header("Content-Disposition: attachment; filename=\"proof.sxcu\"");
        header("Content-Type: application/sxcu;");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo json_encode($json);

    }

}
