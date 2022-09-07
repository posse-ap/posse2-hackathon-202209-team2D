<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["user_id"]) || !isset($_SESSION['login'])) {
    header("Location: auth/login/index.php");
    exit();
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
            ユーザー登録完了画面
        </h1>
    </header>
</body>
    <h2 class="text-md">アカウント作成完了</h2>
    <div class="flex">
        <a href="index.php">管理者画面へ</a>
    </div>
</div>
</html>