<?php

session_start();

$clientMac = $_GET["clientMac"];
$apMac = $_GET["apMac"];
$ssidName = $_GET["ssidName"];
$t = $_GET["t"];
$radioId = $_GET["radioId"];
$site = $_GET["site"];

$seconds = 300;
$username = 'operator1';
$password = 'operator1';

$curl = curl_init();

$postData = [ "name" => $username,
    "password" => $password
];

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
  CURLOPT_POSTFIELDS => json_encode($postData),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

if ($response !== false) {
  $json = json_decode($response, true);
  $csrfToken = $json[result][token];
  echo $csrfToken;
}
else {
  die("Error: check with your network administrator");
}





  // Send user to authorize and the time allowed
$authInfo = array(
'clientMac' => $clientMac,
'apMac' => $apMac,
'ssidName' => $ssidName,
'radioId' => $radioId,
't' => $t,
'time' => $seconds
);

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://192.168.8.175:8043/api/v2/hotspot/login',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_SSL_VERIFYPEER => false,
//   CURLOPT_SSL_VERIFYHOST => false,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
// 	"name": "operator1",
//   "password": "operator1"
// }',
//   CURLOPT_HTTPHEADER => array(
//     'Content-Type: application/json'
//   ),
// ));

// $ch = curl_init();
// // post
// curl_setopt($ch, CURLOPT_POST, TRUE);
// // Set return to a value, not return to page
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// // Set up cookies
// curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE_PATH);
// curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
// // Allow Self Signed Certs    
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
// // API Call
// $csrfToken = self::getCSRFToken();
// curl_setopt($ch, CURLOPT_URL, CONTROLLER_SERVER ."/extportal/". $site."/auth"."?token=".$csrfToken);
// $data = json_encode($authInfo);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($authInfo)); 

// $res = curl_exec($ch);
// $resObj = self::resultConvert($res);

// if($resObj['success'] == false){
//  echo $res;
//  }

// curl_close($ch);










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