<?php
require($_SERVER['DOCUMENT_ROOT'] . "/dbconnect.php");
session_start();

$event_id = $_GET['event_id'];
$stmt = $db->prepare("SELECT * FROM events WHERE id = '$event_id'");
$stmt->execute();
$event = $stmt->fetch();

?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>イベント登録</title>
</head>

<body>

    <main class="bg-gray-100 h-screen">
        <div class="w-full mx-auto py-10 px-5">
            <h2 class="text-md font-bold mb-5">イベント登録登録</h2>
            <form class="flex flex-col" action="../update.php" method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ;?>">
                <input type="text" name="name" placeholder="イベント名" class="w-full p-4 text-sm mb-3" value="<?= $event['name'] ;?>">
                <p class="mb-0 mt-3">イベント内容</p>
                <textarea class="w-full p-4 text-sm mb-4 rounded" name="detail" rows="7" cols="150" value="<?= $event['detail'] ;?>"></textarea>
                <p class="mb-0 mt-3">開始日時</p>
                <input name="start_at" placeholder="<?php echo date('Y-m-d H:i:s'); ?>" class="w-full p-4 text-sm mb-3"  type="datetime-local" required value="<?= $event['start_at'] ;?>">
                <p class="mb-0 mt-3">終了日時</p>
                <input name="end_at" placeholder="<?php echo date('Y-m-d H:i:s'); ?>" class="w-full p-4 text-sm mb-3" type="datetime-local"  required value="<?= $event['end_at'] ;?>">
                <input type="submit" name="submit" value="登録" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
            </form>
        </div>
    </main>
</body>

</html>