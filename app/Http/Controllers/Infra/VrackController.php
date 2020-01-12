<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 21/01/2018
 * Time: 15:10
 */

namespace App\Http\Controllers\Infra;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App;



class VrackController extends Controller
{
    public function index(){

        $hosts = array(
            "u5nPg92T-fluorl",
            "Qp89p4Hz-mmaniaque",
            "7c75rNgB-xmalware",
            "r9i8j5TP-latitchips",
            "d8ApT62z-lordthom",
            "d8P3Fklm-gamercrow",
            "hgb85W7M-sulfique",
            "W2a8B6kb-flofydech",
            "7s8MBa6z-snowice"
        );

        $ips = [];
        foreach ($hosts as $host){
            $hostname = gethostbyname($host . ".badblock-network.fr");
            if ($hostname == $host . ".badblock-network.fr"){
                $hostname = "N/A";
            }
            array_push($ips, $hostname);
        }

        $hosts_key = array(
            "h5XKfKZ48jben7R7za4GWn6YHKwE4r46wh4Qb94EyaU76Tw7mq9U78N7Z6Xkn7FV" => "Qp89p4Hz-mmaniaque",
            "2fTS8iuB2b4wz3v5EWq2mxf6QaqSH3QD9G8365VYMU799AMdPd3avAv2Gpju978Z" => "7c75rNgB-xmalware",
            "y8Z9aAZEyS5jWn9yevCv5B2Sf598fp2M6Se2s5NsiJ5Qu75354Jqv3J5PduLZB3T" => "r9i8j5TP-latitchips",
            "7XD7524p2N9RWjtYULjgKF3PMCa35M76vj94U8s69wMaXag2Dt76wreRb5FtHf2f" => "d8ApT62z-lordthom",
            "APt2aUkKE87DyyVqna45wbQ8jEn5HE47t3W5P7PZZxid77ka73Cfx627NZCK677x" => "hgb85W7M-sulfique",
            "reBJzN7SZ7Z3c272M7Si9seAU2m852WVWsV6nyBsHXS4LE74s4ga3hXc26fgs49r" => "W2a8B6kb-flofydech",
            "HSaG8Vkf5VtqM83N4ZZ36in4725euntv8uF3YC5eHVcWb4iT2i3K476tBt8EhUD6" => "u5nPg92T-fluorl",
            "TAr7qm3c8VCrqCQ9UVwt3m2tm7Gnr9ig6D6aRjU382A472pS8NL9bm8X2D35JyBH" => "7s8MBa6z-snowice",
            "zz" => "d8P3Fklm-gamercrow"
        );




        return view('infra.vrack')->with('hosts', $hosts)->with('ips', $ips);

    }

    public function update($dns, $ip = null){
        $apiKey       = getenv('CLOUDFARE_APIKEY');                         // Your CloudFlare API Key.
        $myDomain     = getenv('CLOUDFARE_DOMAIN');                              // Your domain name.
        $emailAddress = getenv('CLOUDFARE');            // The email address of your CloudFlare account.
        $baseUrl      = 'https://api.cloudflare.com/client/v4/';    // The URL for the CloudFlare API.

        global $headers;
        $headers = array(
            "X-Auth-Email: ".$emailAddress,
            "X-Auth-Key: ".$apiKey,
            "Content-Type: application/json"
        );
        if ($ip == null){
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        $ddnsAddress = $dns;

        function print_err_msg($data) {
            dd($data);
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $type = 'AAAA';
        } else {
            $type = 'A';
        }
        $baseUrl .= 'zones';
        $url = $baseUrl.'?name='.$myDomain;
        $data = $this->send_request("GET",$headers, $url);
        if ($data->success) {
            if (!empty($data->result)) {
                $zoneID = $data->result[0]->id;
                $baseUrl .= '/'.$zoneID.'/dns_records';
            } else {
                die("Zone ".$myDomain." doesn't exist\n");
            }
        } else {
            print_err_msg($data);
        }

        $url = $baseUrl.'?type='.$type;
        $url .= '&name='.$ddnsAddress;
        $data = $this->send_request("GET", $headers, $url);
        if ($data->success) {
            $rec_exists = false;                                    // Assume that the record doesn't exist.
            if (!empty($data->result)) {
                $rec_exists = true;                     // If this runs, it means that the record exists.
                $id = $data->result[0]->id;
                $cfIP = $data->result[0]->content;      // The IP Cloudflare has for the subdomain.
            }
        } else {
            print_err_msg();
        }


        if (gethostbyname($ddnsAddress . ".badblock-network.fr") != $ddnsAddress . ".badblock-network.fr"){
            $rec_exists = true;
        }

        if (!$rec_exists) {
            $fields = array(
                'type' => $type,
                'name' => $ddnsAddress,
                'content' => $ip,
            );
            $url = $baseUrl;
            $data = $this->send_request("POST",$headers, $url, $fields);
            if ($data->success) {
                echo $ddnsAddress."/".$type." record successfully created\n";
            } else {
                print_err_msg($data);
            }
        } elseif ($ip != gethostbyname($ddnsAddress . ".badblock-network.fr")) {
            $fields = array(
                'name' => $ddnsAddress,
                'type' => $type,
                'content' => $ip
            );
            $url = $baseUrl.'/'.$id;
            $data = $this->send_request("PUT", $headers, $url, $fields);
            // Print success/error message.
            if ($data->success) {
                echo $ddnsAddress."/".$type." successfully updated to ".$ip."\n";
            } else {
                print_err_msg($data);
            }
        } else {
            echo $ddnsAddress." / ".$type." is already up to date\n";
        }

    }

    private function send_request($requestType, $headers, $url,$fields = null) {
        $fields_string="";
        if ($requestType == "POST" || $requestType == "PUT") {
            $fields_string = json_encode($fields);
        }
        // Send the request to the CloudFlare API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "curl");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($requestType == "POST" || $requestType == "PUT") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }


    public function disable($dns){
        App::make("App\Http\Controllers\Infra\VrackController")->update($dns, "127.0.0.1");
    }

    public function bat($dns){
        $hosts_key = [
            "Qp89p4Hz-mmaniaque" => "h5XKfKZ48jben7R7za4GWn6YHKwE4r46wh4Qb94EyaU76Tw7mq9U78N7Z6Xkn7FV",
            "7c75rNgB-xmalware" => "2fTS8iuB2b4wz3v5EWq2mxf6QaqSH3QD9G8365VYMU799AMdPd3avAv2Gpju978Z",
            "r9i8j5TP-latitchips" => "y8Z9aAZEyS5jWn9yevCv5B2Sf598fp2M6Se2s5NsiJ5Qu75354Jqv3J5PduLZB3T",
            "d8ApT62z-lelann" => "7XD7524p2N9RWjtYULjgKF3PMCa35M76vj94U8s69wMaXag2Dt76wreRb5FtHf2f",
            "hgb85W7M-sulfique" => "APt2aUkKE87DyyVqna45wbQ8jEn5HE47t3W5P7PZZxid77ka73Cfx627NZCK677x",
            "W2a8B6kb-flofydech" => "reBJzN7SZ7Z3c272M7Si9seAU2m852WVWsV6nyBsHXS4LE74s4ga3hXc26fgs49r",
            "u5nPg92T-fluorl" => "HSaG8Vkf5VtqM83N4ZZ36in4725euntv8uF3YC5eHVcWb4iT2i3K476tBt8EhUD6",
            "7s8MBa6z-snowice" => "TAr7qm3c8VCrqCQ9UVwt3m2tm7Gnr9ig6D6aRjU382A472pS8NL9bm8X2D35JyBH"
        ];

        $token = $hosts_key[$dns];

        $data = "
        ::BadBlock System DDNS
        ::This file was private
        
        set \"token=" . $token ."\"
        curl --data \"auth=%token%\" https://vrack.badblock-network.fr
        
        ";
        header("Content-Disposition: attachment; filename=\"vrack-update-" . $dns .".bat\"");
        header("Content-Type: application/bat");
        header("Content-Description: File Transfer");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $data;

    }


    public function api(){

        $hosts_key = array(
            "h5XKfKZ48jben7R7za4GWn6YHKwE4r46wh4Qb94EyaU76Tw7mq9U78N7Z6Xkn7FV" => "Qp89p4Hz-mmaniaque",
            "2fTS8iuB2b4wz3v5EWq2mxf6QaqSH3QD9G8365VYMU799AMdPd3avAv2Gpju978Z" => "7c75rNgB-xmalware",
            "y8Z9aAZEyS5jWn9yevCv5B2Sf598fp2M6Se2s5NsiJ5Qu75354Jqv3J5PduLZB3T" => "r9i8j5TP-latitchips",
            "7XD7524p2N9RWjtYULjgKF3PMCa35M76vj94U8s69wMaXag2Dt76wreRb5FtHf2f" => "d8ApT62z-lelann",
            "APt2aUkKE87DyyVqna45wbQ8jEn5HE47t3W5P7PZZxid77ka73Cfx627NZCK677x" => "hgb85W7M-sulfique",
            "reBJzN7SZ7Z3c272M7Si9seAU2m852WVWsV6nyBsHXS4LE74s4ga3hXc26fgs49r" => "W2a8B6kb-flofydech",
            "HSaG8Vkf5VtqM83N4ZZ36in4725euntv8uF3YC5eHVcWb4iT2i3K476tBt8EhUD6" => "u5nPg92T-fluorl",
            "TAr7qm3c8VCrqCQ9UVwt3m2tm7Gnr9ig6D6aRjU382A472pS8NL9bm8X2D35JyBH" => "7s8MBa6z-snowice"
        );

        if (!isset($_POST['auth'])){
            return "No token";
        }

        //Check auth & update
        if (!empty($_POST['auth'])){
            if (isset($hosts_key[$_POST['auth']])){
                App::make("App\Http\Controllers\Infra\VrackController")->update($hosts_key[$_POST['auth']], $_SERVER['REMOTE_ADDR']);
            }else{
                return "Invalid token !";
            }
        }
    }

}