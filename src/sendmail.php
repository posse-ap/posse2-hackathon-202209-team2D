<?php
require('dbconnect.php');

date_default_timezone_set('Asia/Tokyo');
mb_language('ja');
mb_internal_encoding('UTF-8');

$start_date  = date('Y-m-d 00:00:00', strtotime("+1 day"));
$end_date  = date('Y-m-d 23:59:59', strtotime("+1 day"));

$stmt = $db->prepare("SELECT events.start_at, events.name AS event_name, events.detail, users.email, users.name FROM events
LEFT JOIN event_attendance ON event_attendance.event_id = events.id 
LEFT JOIN users ON event_attendance.user_id = users.id
WHERE '$start_date' < events.start_at 
AND events.start_at < '$end_date' 
AND event_attendance.status = 1
");
$stmt->execute();
$users = $stmt->fetchAll();

    foreach ($users as $user) {

        $to = $user['email'];
        $subject = "posseイベント前日メール";
        $body = "本文";
        $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

        $name = $user['name'];
        $date = $user['start_at'];
        $event_name = $user['event_name'];
        $detail = $user['detail'];
        $body = <<<EOT
{$name}さん

参加予定の「${event_name}」の前日となりました。
${date}に始まります！

【イベント内容】
${detail}

EOT;

        mb_send_mail($to, $subject, $body, $headers);
    }

echo "メールを送信しました";
