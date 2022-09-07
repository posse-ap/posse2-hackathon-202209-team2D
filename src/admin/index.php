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
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>管理者画面</title>
</head>

<body>
    <header>
        <h1 class="text-2xl m-3 font-bold">
            管理者画面
        </h1>
    </header>
    <div class="m-6">
        <a href="../index.php" class="text-white bg-blue-400 px-4 py-2 rounded-3xl posse-blue-gradation ">ユーザー画面へ</a>
        <a class="text-2xl text-white bg-pink-400 px-4 py-2 rounded-3xl posse-blue-gradation" href="register_user.php">ユーザー登録</a>
    </div>


</body>

</html>