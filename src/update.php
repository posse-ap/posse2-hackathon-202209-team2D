<?php
session_start();
date_default_timezone_set('Asia/Tokyo'); //日本のタイムゾーンに設定
require(dirname(__FILE__) . "/dbconnect.php");
// $user_id = $_SESSION['user_id'];
$date = date("Y-m-d H:i:s");
$event_id = $_POST['event_id'];
$name = $_POST['name'];
$detail = $_POST['detail'];
date_default_timezone_set('Asia/Tokyo');
$updated_at = date("Y-m-d H:i:s");

if(isset($_POST['name'])){
    $start_at = $_POST['start_at'];
    $_SESSION['start_at'] = $start_at;
    $end_at = $_POST['end_at'];
    $_SESSION['end_at'] = $end_at;
    $stmt = $db->prepare("UPDATE events SET name = '$name', detail = '$detail', start_at = '$start_at', end_at = '$end_at' WHERE id = '$event_id'");
    $stmt->execute(); 
    header('Location: admin/index.php');
    exit();
};