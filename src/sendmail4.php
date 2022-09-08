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
    $slack_id = $user['slack_id'];
    $event_name = $user['event_name'];
    $subject = <<<EOT
    ${event_name}　3日前参加可否リマインドメール 
    EOT;
    $body = "本文";
    $headers = ["From" => "system@posse-ap.com", "Content-Type" => "text/plain; charset=UTF-8", "Content-Transfer-Encoding" => "8bit"];
    $name = $user['name'];
    $date = $user['start_at'];
    $detail = $user['detail'];
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

$url = "https://hooks.slack.com/services/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";

// メッセージ
if ( $slack_id != NULL ) {
$message = array(
    "username"   => "POSSEイベント 3日前リマインド",
    "icon_emoji" => ":slack:",
    "attachments" => array(
        array(
            "text" => "<@${slack_id}> \n 3日後に「${event_name}」が開催されます。 \n ${date} から開催です。 \n posseアプリでの参加可否が未回答の方にむけたリマインドの通知です。\n 今すぐ下記リンクより参加可否の登録お願いします！！ \n https://event.posse-ap.com/login \n 【イベント内容】\n ${detail} "            
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
}

echo "メールを送信しました";
