<?php
require('dbconnect.php');
session_start();
//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["user_id"]) || !isset($_SESSION['login'])) {
    header("Location: auth/login/index.php");
    exit();
}

$today = date("Y-m-d");

// 参加/不参加/未回答の分類→未参加のみあとで書き加える
$status = filter_input(INPUT_GET, 'status');
if (isset($status)) {
  if($_GET["status"] == "undefined"){
    $stmt = $db->prepare("SELECT * FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id NOT IN(SELECT event_id FROM event_attendance where user_id = ?) ORDER BY events.start_at ASC" );
    $stmt->execute(array($_SESSION['user_id']));
  }else{
    $stmt = $db->prepare("SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id WHERE events.start_at >= '" . $today . "' AND event_attendance.user_id = ? AND event_attendance.status = ? GROUP BY events.id ORDER BY events.start_at ASC" );
    $stmt->execute(array($_SESSION['user_id'], $status));
  }
}else{
  $stmt = $db->prepare("SELECT events.id, events.name, events.start_at, events.end_at, count(event_attendance.id) AS total_participants FROM events LEFT JOIN event_attendance ON events.id = event_attendance.event_id WHERE events.start_at >= '" . $today . "' GROUP BY events.id ORDER BY events.start_at ASC" );
  $stmt->execute();
}
$events = $stmt->fetchAll();

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM event_attendance LEFT JOIN events ON event_attendance.event_id = events.id LEFT JOIN users ON event_attendance.user_id = users.id where user_id = '$user_id' AND status = 1");
$stmt->execute();
$events_own = $stmt->fetchAll();
function get_day_of_week ($w) {
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
              <a class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200" href="auth/login/logout.php">ログアウト</a>
      </div>     
    </div>
  </header>
  <?php if ($_SESSION['role_id'] == 2): ?>
                <a href="admin/index.php" class="text-white bg-blue-400 px-4 py-2 rounded-3xl posse-blue-gradation ">管理画面へ</a>
  <?php endif; ?>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">
    <p class="ml-5 my-5" >ようこそ <?= $_SESSION['name'] ?> さん</p>
      
      <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">フィルター</h2>
        <div class="flex">
          <!-- <form action="index.php" method="post">
            <input type="hidden" value="1">
            <input type="submit" value="">
          </form> -->
          <a href="/index.php" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">全て</a>
          <a href="/index.php/?status=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">参加</a>
          <a href="/index.php/?status=2" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">不参加</a>
          <a href="/index.php/?status=undefined" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">未回答</a>
        </div>
      </div>
      <div id="events-list">
        <div class="flex justify-between items-center mb-3">
          <h2 class="text-sm font-bold">一覧</h2>
        </div>

        <?php foreach ($events as $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $diff = $start_date - $to;
          $deadline = floor($diff/86400) . '日';
          // echo $diff;
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
          $event_id = $event['id'];
          $stmt = $db->prepare("SELECT * FROM event_attendance LEFT JOIN events ON event_attendance.event_id = events.id LEFT JOIN users ON event_attendance.user_id = users.id where event_id = '$event_id' AND status = 1");
          $stmt->execute();
          $events_users = $stmt->fetchAll();

          $stmt = $db->prepare("SELECT * FROM event_attendance LEFT JOIN events ON event_attendance.event_id = events.id LEFT JOIN users ON event_attendance.user_id = users.id where event_id = '$event_id' AND status = 2");
          $stmt->execute();
          $events_nousers = $stmt->fetchAll();
          ?>
          <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>">
            <div>
            <!-- <h2 class="text-lg font-semibold">不参加者</h2> -->
              <div class="test_false" style="display: none;">
            <?php foreach ($events_nousers as $event_nouser) : ?>
                <?php if($event_nouser['user_id'] == $user_id) :?>
                <input type="hidden" class="hidden_false">
                <?php endif; ?>
                <p><?= $event_nouser['name']; ?></p>
              <?php endforeach; ?>
              <input type="hidden">
              <h2 class="text-lg font-semibold">参加者</h2>
              <div class="test_true">
              <?php foreach ($events_users as $event_user) : ?>
                <?php if($event_user['user_id'] == $user_id) :?>
                <input type="hidden" class="hidden_true">
                <?php endif;?>
                <p><?= $event_user['name']; ?></p>
              <?php endforeach; ?>
              <input type="hidden">
              </div>
            </div>
              <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
              <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
              <p class="text-xs text-gray-600">
                <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
              </p>
            </div>
            <div class="flex flex-col justify-between text-right">
              <div class="answer">
                <?php if ($event['id'] % 3 === 1) : ?>
                  <!--
                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime('-3 day', $end_date)); ?></p>
                  -->
                <?php elseif ($event['id'] % 3 === 2) : ?>
                  
                  <!-- <p class="text-sm font-bold text-gray-300">不参加</p> -->
                 
                <?php else : ?>
                  
                  <!-- <p class="text-sm font-bold text-green-400">参加</p> -->
                 
                <?php endif; ?>
              </div>
              <a class="text-sm click-acord"><span class="text-xl count"></span>人参加 ></a>
              <div class="none" style="display: none;">
              <?php foreach ($events_users as $event_user) : ?>
              <?php if($event_user['user_id'] == $user_id) :?>
                <input type="hidden" class="hidden_true">
                <?php endif;?>
                <p><?= $event_user['name']; ?></p>
              <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

    <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
      <div class="modal-content text-left py-6 pl-10 pr-6">
        <div class="z-50 text-right mb-5">
          <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>

        <div id="modalInner"></div>

      </div>
    </div>
  </div>

  <!-- <script src="/js/main.js"></script> -->
  <script>
    'use strict'
const openModalClassList = document.querySelectorAll('.modal-open')
const closeModalClassList = document.querySelectorAll('.modal-close')
const overlay = document.querySelector('.modal-overlay')
const body = document.querySelector('body')
const modal = document.querySelector('.modal')
const modalInnerHTML = document.getElementById('modalInner')
const testTrue = document.querySelectorAll(".test_true");
const testFalse = document.querySelectorAll(".test_false");
const answer = document.querySelectorAll('.answer');
const count = document.querySelectorAll('.count');
    const [...clickAcords] = document.querySelectorAll('.click-acord');
    const [...nones] = document.querySelectorAll('.none');
    const container = document.querySelector('.modal-container');

for (let i = 0; i < openModalClassList.length; i++) {
  openModalClassList[i].addEventListener('click', (e) => {
    e.preventDefault()
    let eventId = parseInt(e.currentTarget.id.replace('event-', ''))
    openModal(eventId,i)
  }, false)
}

for (var i = 0; i < closeModalClassList.length; i++) {
  closeModalClassList[i].addEventListener('click', closeModal)
}

overlay.addEventListener('click', closeModal)


async function openModal(eventId,index) {
  try {
    const url = '/api/getModalInfo.php?eventId=' + eventId
    const res = await fetch(url)
    const event = await res.json()
    let modalHTML = `
      <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}（${event.day_of_week}）</p>
      <p class="text-sm">${event.start_at} ~ ${event.end_at}</p>
      <hr class="my-4">
      <p class="text-md">
        ${event.message}
      </p>
      <hr class="my-4">
      <p class="text-sm modal-acord"><span class="text-xl">${count[index].innerHTML}</span>人参加 ></p>
      <div class="modal-none" style="display:none;">
        ${testTrue[index].innerHTML}
      </div>
    `
      // let clicks = document.querySelector('.clickAcord');
      // console.log(clicks);
    // const acord = document.querySelector('.modal-acord');
    // acord.innerHTML = testTrue[index].innerHTML;
    switch (0) {
      case 0:
        modalHTML += `
          <div class="text-center mt-6">
            <!--
            <p class="text-lg font-bold text-yellow-400">未回答</p>
            <p class="text-xs text-yellow-400">期限 ${event.deadline}</p>
            -->
          </div>
          <div class="flex mt-5">
          `
          if(testTrue[index].firstElementChild.classList.contains("hidden_true") == true){
            modalHTML += `
            <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})" disabled>参加する</button>
            <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold">参加しない</button>
          </div>
        `
          }else if(testFalse[index].firstElementChild.classList.contains("hidden_false") == true){
            modalHTML += `
            <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId})">参加する</button>
            <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" disabled>参加しない</button>
          </div>
        `
          }
        break;
      case 1:
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-gray-300">不参加</p>
          </div>
        `
        break;
      case 2:
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-green-400">参加</p>
          </div>
        `
        break;
    }
    modalInnerHTML.insertAdjacentHTML('afterbegin', modalHTML)
    let modalAcord = document.querySelector(".modal-acord");
    let modalNone = document.querySelector(".modal-none");
    modalAcord.addEventListener('click', function(e){
      e.stopPropagation();
      if(modalNone.style.display == 'none'){
       modalNone.style.display = "block"
    }else{
      modalNone.style.display = "none"
    }
    })
  } catch (error) {
    console.log(error)
  }
  toggleModal()
}

function closeModal() {
  modalInnerHTML.innerHTML = ''
  toggleModal()
}

function toggleModal() {
  modal.classList.toggle('opacity-0')
  modal.classList.toggle('pointer-events-none')
  body.classList.toggle('modal-active')
}

async function participateEvent(eventId) {
  try {
    let formData = new FormData();
    formData.append('eventId', eventId)
    const url = '/api/postEventAttendance.php'
    await fetch(url, {
      method: 'POST',
      body: formData
    }).then((res) => {
      if(res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    })
    closeModal()
  } catch (error) {
    console.log(error)
  }
}

for (let i = 0; i < openModalClassList.length; i++) {
  clickAcords[i].addEventListener('click',function(e){
    e.stopPropagation();
    // modal.classList.remove('opacity-0')
    // modal.classList.remove('pointer-events-none')
    // body.classList.remove('modal-active')
    if(nones[i].style.display == 'none'){
      clickAcords[i] = nones[i].style.display = "block"
    }else{
      clickAcords[i] = nones[i].style.display = "none"
    }
  })
if(testTrue[i].firstElementChild.classList.contains("hidden_true") == true){
  let answerHTML = `
  <p class="text-sm font-bold text-green-400">参加</p>`
  answer[i].insertAdjacentHTML('beforeend', answerHTML);
}else if(testFalse[i].firstElementChild.classList.contains("hidden_false") == true){
  let answerHTML = `
  <p class="text-sm font-bold text-gray-300">不参加</p>
  `
  answer[i].insertAdjacentHTML('beforeend', answerHTML);
}else{
  let answerHTML = `
  <p class="text-sm font-bold text-yellow-400">未回答</p>
  <p class="text-xs text-yellow-400">期限<?= $deadline ;?></p>
  `
  answer[i].insertAdjacentHTML('beforeend', answerHTML);
}
}


for (let i = 0; i < openModalClassList.length; i++) {
if(testTrue[i].firstElementChild.classList.contains("hidden_true") == true){
    let counter = (testTrue[i].childElementCount) - 2 ;
    count[i].insertAdjacentHTML('beforeend', counter); 
  }else{
    let counter = (testTrue[i].childElementCount) -1;
    count[i].insertAdjacentHTML('beforeend', counter);
  }
}
  </script>
</body>

</html>
