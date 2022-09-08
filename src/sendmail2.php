<?php
require('dbconnect.php');

date_default_timezone_set('Asia/Tokyo');
mb_language('ja');
mb_internal_encoding('UTF-8');

$start_date  = date('Y-m-d 00:00:00', strtotime("+1 day"));
$end_date  = date('Y-m-d 23:59:59', strtotime("+1 day"));

$stmt = $db->prepare("SELECT events.start_at, events.name AS event_name, events.detail, users.email, users.slack_id, users.name FROM events
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
        $slack_id = $user['slack_id'];
        $event_name = $user['event_name'];
        $subject = <<<EOT
            ${event_name}前日リマインド 
            EOT;        
        $body = "本文";
        $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];

        $name = $user['name'];
        $date = $user['start_at'];
        $detail = $user['detail'];
        $body = <<<EOT
{$name}さん

参加予定の「${event_name}」の前日となりました。
${date}に始まります！

【イベント内容】
${detail}

EOT;

    mb_send_mail($to, $subject, $body, $headers);

$url = "https://hooks.slack.com/services/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";

// メッセージ
$message = array(
    "username"   => "POSSEイベント 前日リマインド",
    "icon_emoji" => ":slack:",
    "attachments" => array(
        array(
            "text" => "<@${slack_id}> \n 参加予定の「${event_name}」の前日となりました。 \n ${date} 開催です！ \n 【イベント内容】\n ${detail} "
            // `参加予定の「${event_name}」の前日となりました。\n${date} 開催です。 \n【イベント内容】\n${detail}`
            
        )
    )
);

$message_json = json_encode($message);

// payloadの値としてURLエンコード
$message_post = "payload=".urlencode($message_json);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $message_post);
curl_exec($ch);
curl_close($ch);

}

echo "メールを送信しました";
