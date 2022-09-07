<?php
require('dbconnect.php');

date_default_timezone_set('Asia/Tokyo');
mb_language('ja');
mb_internal_encoding('UTF-8');

$start_date  = date('Y-m-d 00:00:00', strtotime("+3 day"));
$end_date  = date('Y-m-d 23:59:59', strtotime("+3 day"));

$stmt = $db->prepare("SELECT events.name event_name, events.detail, events.start_at, users.*
FROM  events 
CROSS JOIN users
WHERE '$start_date' < start_at 
AND start_at < '$end_date'
and not exists (
select * from event_attendance ea
    where ea.user_id = users.id
    and ea.event_id = events.id
    )  
ORDER BY `event_name` ASC;
");
$stmt->execute();
$users = $stmt->fetchAll();

foreach ($users as $user) {

    $to = $user['email'];
    $event_name = $event['name'];
    $subject = <<<EOT
    ${event_name}　3日前参加可否リマインドメール 
    EOT;
    $body = "本文";
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

    $name = $user['name'];
    $date = $event['start_at'];
    $detail = $event['detail'];
    $body = <<<EOT
{$name}さん

3日後の ${date}に << ${event_name} >>を開催します。

このメールは、posseアプリでの参加可否が未回答の方にむけたリマインドのメールです。
今すぐ下記リンクより参加可否の登録お願いします！！
https://event.posse-ap.com/login

【イベント内容】
${detail}


ぜひ来てください！！！
EOT;

    mb_send_mail($to, $subject, $body, $headers);
}

echo "メールを送信しました";
