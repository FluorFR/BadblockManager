<?php
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 17/02/2019
 * Time: 13:38
 */

namespace App\Http\Controllers\section;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class URLShortenerManagerController extends Controller
{

    private $URLShortener_domain = "https://bblock.pw/";

    public function index(){

        $urls_all = DB::connection('mongodb')->collection('url_shortener')->orderBy("created_at", "DESC")->get();

        return view('section.urlShortenerManager', ["URLs_all" => $urls_all, "URLShortener_domain" => $this->URLShortener_domain]);
    }

    public function post(){

        if(isset($_POST["comesFrom"])){

            if($_POST['comesFrom'] == "delete"){

                DB::connection('mongodb')->collection('url_shortener')->where('_id', strip_tags($_POST['urlToDelete']))->delete();

            }

            elseif($_POST['comesFrom'] == "create" || $_POST['comesFrom'] == "modify"){

                $urls_all = DB::connection('mongodb')->collection('url_shortener')->select("url_shortened")->get();
                $URLs_Shortened = [];

                foreach ($urls_all as $i => $url) {
                    $URLs_Shortened[$i] = $url['url_shortened'];
                }

                if(in_array($this->URLShortener_domain.strip_tags($_POST['urlShortened']), $URLs_Shortened)) {
                    return response()->json(["error" => "L'URL personnalisé existe déjà, merci d'en choisir un nouveau"], 409); // Status code here
                }

                if(!filter_var($_POST['urlToShort'], FILTER_VALIDATE_URL)){
                    return response()->json(["error" => "Merci d'entrer une URL valide"], 409);
                }

                if(!preg_match("/[a-zA-Z0-9\-_]/", $_POST['urlShortened']) || !filter_var($this->URLShortener_domain.$_POST['urlShortened'], FILTER_VALIDATE_URL)){
                    return response()->json(['error' => "Merci d'entrer une URL raccourcie valide "], 409);
                }

                if($_POST['comesFrom'] == "create") {
                    DB::connection('mongodb')->collection('url_shortener')->insert([
                        'url_origin' => strip_tags($_POST['urlToShort']),
                        'url_shortened' => $this->URLShortener_domain . strip_tags($_POST['urlShortened']),
                        'clickCounter_BadblockPlayers' => 0,
                        'clickCounter_Unregistered' => 0
                    ]);
                }

                elseif($_POST['comesFrom'] == "modify"){
                    DB::connection('mongodb')->collection('url_shortener')->where("_id", $_POST["id"])->update([
                        'url_origin' => strip_tags($_POST['urlToShort']),
                        'url_shortened' => $this->URLShortener_domain . strip_tags($_POST['urlShortened'])
                    ]);
                }

            }
        }

    }

}