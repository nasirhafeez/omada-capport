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
curl_setopt($ch, CURLOPT_URL, CONTROLLER_SERVER . "/login");
curl_setopt($ch, CURLOPT_POSTFIELDS, "name=" . $_SESSION["name"] ."&password=" . $_SESSION["password"]);
    $res = curl_exec($ch);
    $resObj = json_decode($res);
//Prevent CSRF
              if($resObj->success == true){
                              self::setCSRFToken($resObj->value);
              }
curl_close($ch);
}

private static function setCSRFToken($token){
                $myfile = fopen(TOKEN_FILE_PATH, "w") or die("Unable to open file!");
                fwrite($myfile, $token);
                fclose($myfile);
                return $token;
}

private static function authorize($clientMac,$apMac,$ssidName,$radioId,$t,$seconds,$site) {
     // Send user to authorize and the time allowed
$authInfo = array(
'clientMac' => $clientMac,
'apMac' => $apMac,
''ssidName => $ssidName,
'radioId ' => $radioId,
't' => $t,
'time' => $seconds
);

$ch = curl_init();
// post
curl_setopt($ch, CURLOPT_POST, TRUE);
// Set return to a value, not return to page
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Set up cookies
curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE_PATH);
curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
// Allow Self Signed Certs    
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
// API Call
$csrfToken = self::getCSRFToken();
curl_setopt($ch, CURLOPT_URL, CONTROLLER_SERVER ."/extportal/". $site."/auth"."?token=".$csrfToken);
$data = json_encode($authInfo);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($authInfo)); 

$res = curl_exec($ch);
$resObj = self::resultConvert($res);

if($resObj['success'] == false){
    echo $res;
    }

curl_close($ch);

}

 

private static function resultConvert($json) {       
$json = str_replace(array('{','}',':',','),array('[{" ',' }]','":',',"'),$json);

function cb_quote($v) {
    return '"'.trim($v[1]).'"';
    }

$newJSON=preg_replace_callback("~\"(.*?)\"~","cb_quote", $json);
$res = json_decode($newJSON, true)[0];
return $res;
}

private static function getCSRFToken(){
                $myfile = fopen(TOKEN_FILE_PATH, "r") or die("Unable to open file!");
                $token = fgets($myfile);
                fclose($myfile);
                return $token;
}

?>