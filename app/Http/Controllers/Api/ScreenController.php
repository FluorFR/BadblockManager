<?php

namespace App\Http\Controllers\Api;

use App\Models\ShareX;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
{

    public function upload()
    {
        $Data = DB::table('shareX')->where('token', '=', $_POST['token'])->first();

        if ($Data == null){
            header('HTTP/1.0 401 Unauthorized');
            return "Nop";
        }

        $User = DB::table('users')->where('id', '=', $Data->user_id)->first();


        //Upload file
        $data = file_get_contents($_FILES['image']['tmp_name']);
        $base64 = 'data:image/' . "png" . ';base64,' . base64_encode($data);

        $handle = fopen($base64, 'r');

        //Upload to FTP
        // Mise en place d'une connexion basique
        $conn_id = ftp_connect(getenv('FTP_IP'), 19728);

        $filename = date("Y-m-d-H-i") . uniqid() . ".png";

        // Identification avec un nom d'utilisateur et un mot de passe
        $login_result = ftp_login($conn_id, getenv('FTP_USER'), getenv('FTP_PASSWORD')) or die("Erreur serveur !");;
        ftp_pasv($conn_id, true) or die("Erreur serveur !");

        ftp_fput($conn_id, $filename , $handle,FTP_ASCII) or die("Erreur serveur !");;
        fclose($handle);

        DB::table('shareX')->where('token', '=', $_POST['token'])->update([
            'last_used' => date("Y-m-d H:i:s"),
            'last_ip' => $_SERVER['REMOTE_ADDR']
        ]);

        //Save dans MongoDB
        $data = [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user' => strtolower($User->name),
            'date' => date("Y-m-d H:i:s"),
            'file_name' => $filename
        ];
        DB::connection('mongodb')->collection('log_upload')->insert($data);

        return redirect('https://cdn.badblock.fr/upload/' . $filename);
    }

}
