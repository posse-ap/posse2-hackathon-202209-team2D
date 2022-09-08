<?php
require('../dbconnect.php');
header('Content-Type: application/json; charset=UTF-8');
session_start();
$user_id = $_SESSION['user_id'];
$eventId = $_POST['eventId'];
$status = $_POST['status'];

if ($status == "update1") {
  $stmt = $db->prepare("UPDATE event_attendance SET status=1 where event_id='$eventId' AND user_id='$user_id'");
  $stmt->execute();
}elseif ($status == "update2"){
  $stmt = $db->prepare("UPDATE event_attendance SET status=2 where event_id='$eventId' AND user_id='$user_id'");
  $stmt->execute();
}elseif ($status == "insert"){
  $stmt = $db->prepare("INSERT INTO event_attendance SET event_id='$eventId' ,user_id='$user_id' , status=1 ");
  $stmt->execute();
}else{
  $stmt = $db->prepare("INSERT INTO event_attendance SET event_id='$eventId' ,user_id='$user_id' , status=2 ");
  $stmt->execute();
}
