<?php
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 27/02/2019
 * Time: 12:29
 */

namespace App\Http\Controllers\profile;


class BuilderFileUploaderController
{

    public function index(){

        return view('profil.builderFileUploader');
    }

    public function upload()
    {

        $file = $_FILES['uploadedFile'];

        // Identification avec un nom d'utilisateur et un mot de passe
        $server = env('FTP_BUILD_IP');
        $port = env('FTP_BUILD-PORT');
        $username = env('FTP_BUILD_USER');
        $passwd = env('FTP_BUILD_PASSWORD');

        $extensions = array("application/octet-stream");
        $response = array();

        if(!in_array($file['type'], $extensions)){
            array_push($response,  ["error", "Merci d'uploader un .schematic"]);
        }

// connect
        $connection = ssh2_connect($server, $port);

        if (ssh2_auth_password($connection, $username, $passwd)) {
// initialize sftp
            $sftp = ssh2_sftp($connection);

// Upload file
            echo "Connection successful, uploading file now..."."n";

            $name = $file["name"];
            $contents = file_get_contents($file['tmp_name']);
            file_put_contents("ssh2.sftp://{$sftp}/plugins/WorldEdit/schematics/{$name}", $contents);

        } else {
            array_push($response, ["error", "Impossible de se connecter au serveur SFTP, merci de contacter un administrateur"]);
        }

        array_push($response,  ["success", "Fichier envoyé au serveur SFTP"]);
        return view('profil.builderFileUploader', ['response' => $response]);

    }
}