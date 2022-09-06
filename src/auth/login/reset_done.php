<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

try {

    $db = new PDO($dsn, $user, $password);
    $stmt = $db->prepare('UPDATE users SET login_pass = :login_pass WHERE email = :email');
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $stmt->execute(array(':email' => $_POST['email'], ':login_pass' => $pass));

} catch (Exception $e) {
    echo "データベースの接続に失敗しました：";
    echo $e->getMessage();
    die();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作成完了画面</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="../style/login.css">
</head>

<body>
    <header>
        <h1>
            <p class="agent_login">パスワードリセット完了画面</p>
        </h1>
    </header>
</body>
<div class="done">
    <h2 class="agent_login_title">パスワードリセット完了</h2>
    <div class="to_login">
        <a href="index.php">こちら</a>
        <p>からログインをしてください。</p>
    </div>
</div>

</html>