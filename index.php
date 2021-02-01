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
  $csrfToken = $json['result']['token'];
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

$url = 'https://192.168.8.175:8043/api/v2/hotspot/extportal/auth?token='.$csrfToken;

$curlAuth = curl_init();

curl_setopt_array($curlAuth, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($authInfo),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

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

$res = curl_exec($curlAuth);
// $resObj = self::resultConvert($res);

// if($resObj['success'] == false){
//  echo $res;
//  }

curl_close($curlAuth);

echo $res;

?>