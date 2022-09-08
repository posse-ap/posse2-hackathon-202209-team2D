<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

if (isset($_POST["submit"])) {
  try {
    $db = new PDO("$dsn", "$user", "$password");
    $stmt = $db->prepare('SELECT id, email, login_pass FROM users WHERE email = :email limit 1');
    $stmt->bindValue(':email',  $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $_SESSION["user_id"] = $result["id"];
      $_SESSION['pass'] = $_POST['pass'];
      $_SESSION["login"] = $_POST['email']; //セッションにログイン情報を登録

      echo $_POST['email'];

  } catch (PDOException $e) {
    echo "もう一回";
    $msg = $e->getMessage();
    exit;
  }
}

// if($_POST['email'] == null) {
//     header("Location: reset_done.php"); 
// }

?>

<!DOCTYPE html>
<html>

<head>
    <title>パスワードリセット</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="../style/login.css">
</head>

<body>
    <header>
        <h1>
            <p>POSSEアプリパスワードリセット画面</p>
        </h1>
    </header>
    <div class="agent_login_info">
        <!-- <h2 class="agent_login_title">アカウント作成</h2> -->
        <form action="reset_done.php" method="post">
            <input type="hidden" name="id" value="<?php echo(htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'));?>">
            <p>
                <label>メールアドレス：</label>
                <input type="text" name="email" required>
            </p>
            <p>
                <label>パスワード：</label>
                <input type="password" name="pass" required>
            </p>

            <input type="submit" name="submit" value="リセットする">
        </form>
    </div>
</body>

</html> 