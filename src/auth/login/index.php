<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

if (isset($_POST["submit"])) {
  try {
    $db = new PDO("$dsn", "$user", "$password");
    $stmt = $db->prepare('SELECT id, name, email, login_pass, role_id FROM users WHERE email = :email limit 1');
    $email = $_POST['email'];
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($_POST['pass'], $result['login_pass'])) {
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION["user_id"] = $result["id"];
      $_SESSION["role_id"] = $result["role_id"];
      $_SESSION['name'] = $result['name'];
      $_SESSION["login"] = $_POST['email']; //セッションにログイン情報を登録
      header('Location: ../../index.php');
    } else {
      $msg = 'メールアドレスもしくはパスワードが間違っています。';
    }
  } catch (PDOException $e) {
    echo "もう一回";
    $msg = $e->getMessage();
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="/img/header-logo.png" alt="" class="h-full">
      </div>
    </div>
  </header>

  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">ログイン</h2>
      <form action="" method="POST">
        <?php if (isset($msg)) : ?>
          <h3 class="text-red-400 my-3"><?php echo $msg; ?></h3>
        <?php endif; ?>
        <input type="text" name="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" required>
        <input type="password" name="pass" placeholder="パスワード" class="w-full p-4 text-sm mb-3" required>
        <!-- <label class="inline-block mb-6">
          <input type="checkbox" checked>
          <span class="text-sm">ログイン状態を保持する</span>
        </label> -->
        <input type="submit" name="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="reset.php">パスワードを忘れた方はこちら</a>
        <!-- 1. Githubログインページへの遷移 -->
        <a href="https://github.com/login/oauth/authorize?client_id=21099cba3a90e21d4f87&scope=user:email">|      Log in with GitHub</a>
      </div>
    </div>
  </main>
</body>

</html> 