<?php
require('../dbconnect.php');
session_start();
//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["user_id"]) || !isset($_SESSION['login'])) {
    header("Location: auth/login/index.php");
    exit();
}

$today = date("Y-m-d");

// 参加/不参加/未回答の分類→未参加のみあとで書き加える
$stmt = $db->prepare("SELECT * FROM events WHERE events.start_at >= '" . $today . "' ORDER BY events.start_at ASC");
$stmt->execute();
$events = $stmt->fetchAll();

function get_day_of_week($w)
{
    $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
    return $day_of_week_list["$w"];
}
date_default_timezone_set('Asia/Tokyo');
$to   = strtotime("now");
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
                <img src="img/header-logo.png" alt="" class="h-full">
            </div>
            <div>
                <a class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200" href="../auth/login/logout.php">ログアウト</a>
            </div>
        </div>
    </header>

    <main class="bg-gray-100">
        <div class="w-full mx-auto p-5">
            <div id="events-list">
                <div class="flex justify-between items-center mb-3 flex-col">
                    <h2 class="text-sm font-bold">一覧</h2>
                </div>
                <?php foreach ($events as $event) :
                    $start_date = strtotime($event['start_at']);
                    $diff = $start_date - $to;
                    $deadline = floor($diff / 86400) . '日';
                    // echo $diff;
                    $end_date = strtotime($event['end_at']);
                    $day_of_week = get_day_of_week(date("w", $start_date));
                ?>
                    <form action="edit_event.php" action="GET">
                        <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer flex-col" id="event-<?php echo $event['id']; ?>">
                            <div>
                                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>" />
                                <!-- <h2 class="text-lg font-semibold">不参加者</h2> -->
                            </div>
                            <h3 class="font-bold text-md mb-2"><?php echo $event['name'] ?></h3>
                            <p class="text-xs"><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
                            <p class="text-xs text-gray-600">
                                <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
                            </p>
                            <input type="submit" value="編集" class="bg-blue-300">
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>

</html>