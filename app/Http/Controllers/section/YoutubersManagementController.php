<?php
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 07/03/2019
 * Time: 16:17
 */

namespace App\Http\Controllers\section;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class YoutubersManagementController extends Controller
{

    private $db = 'mongodb';
    private $collection = 'youtuber_list';

        public function index(){

            $youtubers = DB::connection($this->db)->collection($this->collection)->get();

            return view('section.youtubers', ['Youtubers' => $youtubers]);

        }

        public function post(){

            if(isset($_POST)){

                if(isset($_POST['comesFrom'])){

                    if($_POST['comesFrom'] == "create"){

                        DB::connection($this->db)->collection($this->collection)->insert([
                            "youtuber_name" => strip_tags($_POST['youtuber_name']),
                            "youtuber_uuid" => str_replace('/', '',
                                str_replace('https://youtube.com/channel/', '',
                                str_replace('https://youtu.be/channel/', '',
                                    str_replace('www.', '', $_POST['youtuber_url'])))),
                            "youtuber_power" => strip_tags($_POST['youtuber_power'])
                        ]);

                    }

                    elseif($_POST['comesFrom'] == "delete"){

                        DB::connection($this->db)->collection($this->collection)->where('youtuber_name', strip_tags($_POST['youtuber_name']))->delete();

                    }

                }
            }

        }

}