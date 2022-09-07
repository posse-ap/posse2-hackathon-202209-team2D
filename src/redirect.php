<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

$dsn = 'mysql:host=mysql;dbname=posse;charset=utf8;';
$user = 'posse_user';
$password = 'password';

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

// 3. アクセストークンの取得
$resultAT = httpRequest('post', "https://github.com/login/oauth/access_token", $POST_DATA, ["Accept: application/json"]);
//  APIでユーザのEmail情報を取得
$resultEmail   = httpRequest('get', "https://api.github.com/user/emails", null, ["Authorization: Token " . "アクセストークン"]);

// 返却地をJsonでデコード
$resJsonAT = json_decode($resultAT, true);
// 返却地をJsonでデコード
$resJsonEmails = json_decode($resultEmail, true);

// アクセストークン
echo $resJsonAT['access_token'];
echo $resJsonEmails[0]['email'];

// 4. APIでユーザ情報の取得
$resultUser = httpRequest('get', "https://api.github.com/user", null, ["Authorization: Token " . $resJsonAT['access_token']]);
// 返却地をJsonでデコード
$resJsonUser = json_decode($resultUser, true);

// ユーザ情報
var_dump($resJsonUser);
// echo $resJsonUser[0]["name"];
$git_id = $resJsonUser[0]["login"];
echo $git_id;
$git_name = $resJsonUser["name"];
$git_email = $resJsonEmails['email'];

// DB登録処理とか
// 〜〜〜もし既にある情報と一致してなかったら新規登録〜〜〜
$db = new PDO($dsn, $user, $password);
$stmt = $db->prepare("INSERT INTO users (email, name, login_pass, slack_id, github_id, role_id) VALUES (:email, :name, :login_pass, :slack_id, :github_id, :role_id)");
$stmt->execute(array(':email' => $git_email, ':name' => $git_name, ':login_pass' => password_hash('password', PASSWORD_DEFAULT), ':slack_id' => 123456, ':github_id' => $git_id,  ':role_id' =>'1'));


if (isset($git_id)) {
    session_regenerate_id(TRUE); //セッションidを再発行
    $_SESSION["user_id"] = 123456; //仮
    $_SESSION["role_id"] = 1;
    $_SESSION['name'] = $git_name;
    $_SESSION["login"] = $git_email; //セッションにログイン情報を登録
    header('Location: ../../index.php');
}