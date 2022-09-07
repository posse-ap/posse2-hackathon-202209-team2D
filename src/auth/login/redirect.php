<?php
require( "../../dbconnect.php");
session_start();


/**
 * HTTPリクエスト用の関数
 */
function httpRequest($curlType, $url, $params = null, $header = null)
{
    $headerParams = $header;
    $curl         = curl_init($url);
 
    if ($curlType == 'post') {
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    }
    else {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    }
 
    curl_setopt($curl, CURLOPT_USERAGENT, "USER_AGENT");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  // オレオレ証明書対策
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);  // 
    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie');
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'tmp');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headerParams);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

// 2.codeの取得
$code = filter_input(INPUT_GET, "code");

// ポストするパラメータを生成
$POST_DATA = array(
    'client_id'     => '21099cba3a90e21d4f87',
    'client_secret' => '77d227c196ab3766c19a9041e106cc8e88f14438',
    'code'          => $code,
);

// 3. アクセストークンの取得→返却値をJsonでデコード
$resultAT = httpRequest('post', "https://github.com/login/oauth/access_token", $POST_DATA, ["Accept: application/json"]);
$resJsonAT = json_decode($resultAT, true);

// アクセストークン
// echo $resJsonAT['access_token'];

// 4. APIでユーザ情報の取得→返却値をJsonでデコード
$resultUser = httpRequest('get', "https://api.github.com/user", null, ["Authorization: Token " . $resJsonAT['access_token']]);
$resJsonUser = json_decode($resultUser, true);
// var_dump($resJsonUser);
$git_id = $resJsonUser["login"];
$git_name = $resJsonUser["name"];

//  APIでユーザのEmail情報を取得→返却値をJsonでデコード
$resultEmail   = httpRequest('get', "https://api.github.com/user/emails", null, ["Authorization: Token " . $resJsonAT['access_token']]);
$resJsonEmails = json_decode($resultEmail, true);
$git_email = $resJsonEmails[0]['email'];
