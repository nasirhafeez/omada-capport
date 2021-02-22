<?php

session_start();

$clientMac = $_GET["clientMac"];
$apMac = $_GET["apMac"];
$ssidName = $_GET["ssidName"];
$t = $_GET["t"];
$radioId = $_GET["radioId"];
$site = $_GET["site"];
$cookiePath = "cookies/".$clientMac;

$seconds = 300000;
$username = 'operator1';
$password = 'operator1';

$curl = curl_init();

$postData = [ "name" => $username,
    "password" => $password
];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://192.168.8.175:8043/api/v2/hotspot/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_COOKIEJAR => $cookiePath,
  CURLOPT_COOKIEFILE => $cookiePath,
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
  $csrfToken = $json['result']['token'];
}
else {
  die("Error: check with your network administrator");
}

echo $csrfToken;

// $postData = [ "clientMac" => $clientMac,
//   "apMac" => $apMac,
//   'ssidName' => $ssidName,
//   't' => $t,
//   'radioId' => $radioId,
//   'site' => $site,
//   'authType' => 4,
//   'time' => $seconds
// ];

// // $authInfo = array(
// // 'clientMac' => $clientMac,
// // 'apMac' => $apMac,
// // 'ssidName' => $ssidName,
// // 't' => $t,
// // 'radioId' => $radioId,
// // 'site' => $site,
// // 'authType' => 4,
// // 'time' => $seconds
// // );

// $url = 'https://192.168.8.175:8043/api/v2/hotspot/extPortal/auth?token='.$csrfToken;

// $curlAuth = curl_init();

// curl_setopt_array($curlAuth, array(
//   CURLOPT_URL => $url,
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_SSL_VERIFYPEER => false,
//   CURLOPT_SSL_VERIFYHOST => false,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => json_encode($authInfo),
//   CURLOPT_HTTPHEADER => array(
//     'Content-Type: application/json'
//   ),
// ));

// $res = curl_exec($curlAuth);
// // $resObj = self::resultConvert($res);

// // if($resObj['success'] == false){
// //  echo $res;
// //  }

// curl_close($curlAuth);

// echo $res;

?>