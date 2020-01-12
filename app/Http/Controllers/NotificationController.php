<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Notifications;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class NotificationController extends Controller
{

    public function index($id){
        $data = Notifications::where('id', '=', $id)->get()[0];

        if (!isset($data)){
            return redirect('/');
        }

        if ($data->user_id == Auth::user()->id){
            Notifications::where('id', '=', $id)->update([
                'active' => false,
                'click_at' => date("Y-m-d H:i:s")
            ]);

            return redirect($data->link);
        }
        return redirect('/');
    }


}