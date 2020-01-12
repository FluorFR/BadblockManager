<?php

/**
 * Created by Atom.
 * User: Hooki
 * Date: 05/01/2019
 * Time: 22:14
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
      return view('profil.index');
    }

    public function reset(Request $request)
    {
        if($request->input('password') == $request->input('password_verif')) {

            DB::table('users')->where('id', '=', Auth::user()->id)->update([
                'password' => password_hash($request->password, PASSWORD_DEFAULT)
            ]);

            return redirect('/profil');

        }
        else {
            return view('profil.index', ['error' => 'Les deux mots de passe ne correspondent pas.']);
        }
    }

}
