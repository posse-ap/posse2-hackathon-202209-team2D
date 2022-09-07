<?php
require('dbconnect.php');
date_default_timezone_set('Asia/Tokyo');
mb_language('ja');
mb_internal_encoding('UTF-8');


$stmt = $db->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();

// $date  = date("Ymd",strtotime("-1 day"));
$start_date  = date('Y-m-d 00:00:00',strtotime("+3 day"));
$end_date  = date('Y-m-d 23:59:59',strtotime("+3 day"));

$stmt2 = $db->prepare("SELECT * FROM events where '$start_date' < start_at AND start_at < '$end_date'");
$stmt2->execute();
$events = $stmt2->fetchAll();

foreach ($events as $event) {
foreach ($users as $user) {

$to = $user['email'];
$event_name = $event['name'];
$subject = <<<EOT
    ${event_name}　3日前リマインドメール 
    EOT;
$body = "本文";
$headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];

$name = $user['name'];
$date = $event['start_at'];
$detail = $event['detail'];
$body = <<<EOT
{$name}さん


3日後の ${date}に << ${event_name} >>を開催します。

posseアプリで回答をまだしていない人は今すぐ参加可否の登録お願いします！！
https://event.posse-ap.com/login

【イベント内容】
${detail}


ぜひ来てください！！！
EOT;

mb_send_mail($to, $subject, $body, $headers);
}
}
echo "メールを送信しました";