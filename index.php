<?php

session_start();

$_SESSION["clientMac"] = $_GET["clientMac"];
$_SESSION["apMac"] = $_GET["apMac"];
$_SESSION["ssidName"] = $_GET["ssidName"];
$_SESSION["t"] = $_GET["t"];
$_SESSION["radioId"] = $_GET["radioId"];
$_SESSION["site"] = $_GET["site"];

$_SESSION["time"] = 300;
$_SESSION["name"] = 'operator1';
$_SESSION["password"] = 'operator1';

class TPLinkAuth
{
    private static function login() {       
    $ch = curl_init();
    // post
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // Set return to a value, not return to page
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Set up cookies
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
    // Allow Self Signed Certs
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // API Call
    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
    curl_setopt($ch, CURLOPT_URL, "https://192.168.8.175:8043" . "/api/v2/hotspot/login");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "name=" . $_SESSION["name"] ."&password=" . $_SESSION["password"]);
        $res = curl_exec($ch);
        $resObj = json_decode($res);

    //Prevent CSRF
                // if($resObj->success == true){
                //     echo "setting csrf token";
                //                 self::setCSRFToken($resObj->value);
                // }
    curl_close($ch);
    }

    // private static function setCSRFToken($token) {
    //                 $myfile = fopen("../token.txt", "w") or die("Unable to open file!");
    //                 fwrite($myfile, $token);
    //                 fclose($myfile);
    //                 return $token;
    // }
}

try { 
    $tplink_C = new TPLinkAuth();
echo "try 2";
//    $access_token = $tplink_C->login();
$user_info = $tplink_C->login();
echo json_encode($user_info);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

?>