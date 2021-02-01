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

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://192.168.8.175:8043/api/v2/hotspot/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"name": "operator1",
  "password": "operator1"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$abc = json_encode($response);

echo $response;

// class TPLinkAuth
// {
//     function login() {       
//     $ch = curl_init();
//     // post
//     curl_setopt($ch, CURLOPT_POST, TRUE);
//     // Set return to a value, not return to page
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     // Set up cookies
//     curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
//     curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
//     // Allow Self Signed Certs
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//     // API Call
//     curl_setopt($ch, CURLOPT_URL, "https://192.168.8.175:8043/api/v2/hotspot/login");
//     curl_setopt($ch, CURLOPT_POSTFIELDS, "name=" . "operator1" ."&password=" . "operator1");
//         $res = curl_exec($ch);
//         $resObj = json_decode($res);
//         echo $res;
//     //Prevent CSRF
//                 // if($resObj->success == true){
//                 //     echo "setting csrf token";
//                 //                 self::setCSRFToken($resObj->value);
//                 // }
//     curl_close($ch);
//     }

//     private static function setCSRFToken($token) {
//                     $myfile = fopen("../token.txt", "w") or die("Unable to open file!");
//                     fwrite($myfile, $token);
//                     fclose($myfile);
//                     return $token;
//     }
// }

// try { 
//     $tplink_C = new TPLinkAuth();
// echo "try 2";
//     $user_info = $tplink_C->login();
//     echo json_encode($user_info);

// } catch (Exception $e) {
//     echo $e->getMessage();
//     exit;
// }

?>