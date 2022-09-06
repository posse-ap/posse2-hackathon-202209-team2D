<?php
session_start();
$output = '';
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
}
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
//セッションクリア
@session_destroy();

echo $output;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログアウトページ</title>
</head>

<body>

    <div class="text-2xl mx-20 my-100">
        <p class="mb-20">ログアウトしました</p>
        <a href="index.php">ログインページへ</a>
    </div>
</body>

</html>