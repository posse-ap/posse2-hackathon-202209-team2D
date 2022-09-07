<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["user_id"]) || !isset($_SESSION['login'])) {
    header("Location: auth/login/index.php");
    exit();
}

$dsn = 'mysql:host=mysql;dbname=posse;charset=utf8;';
$user = 'posse_user';
$password = 'password';

try{

$db = new PDO($dsn, $user, $password);

$stmt = $db->prepare("INSERT INTO users (email, name, login_pass, slack_id, github_id, role_id) VALUES (:email, :name, :login_pass, :slack_id, :github_id, :role_id)");

$stmt->execute(array(':email' => $_POST['email'], ':name' => $_POST['name'], ':login_pass' => password_hash($_POST['pass'], PASSWORD_DEFAULT), ':slack_id' => $_POST['slack_id'], ':github_id' => $_POST['github_id'],  ':role_id' => $_POST['role_id'],));

}catch(Exception $e){
    echo "データベースの接続に失敗しました：";
    echo $e->getMessage();
    die();
}

if($_POST['email'] != null) {
    header("Location: register_done.php"); 
}

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>ユーザー登録</title>
</head>

<body>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">ユーザー登録</h2>
      <form class="flex flex-col" action="" method="POST">
        <input type="text" name="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" required>
        <input type="text" name="name" placeholder="名前" class="w-full p-4 text-sm mb-3" required>
        <input type="password" name="pass" placeholder="パスワード" class="w-full p-4 text-sm mb-3" required>
        <input type="text" name="slack_id" placeholder="slack_id" class="w-full p-4 text-sm mb-3" required>
        <input type="text" name="github_id" placeholder="github_id" class="w-full p-4 text-sm mb-3" required>
        <input type="int" name="role_id" placeholder="管理者権限を付与する場合は2、それ以外は1" class="w-full p-4 text-sm mb-3" required>
        <input type="submit" name="submit" value="登録" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
    </div>
  </main>
</body>
</html>
