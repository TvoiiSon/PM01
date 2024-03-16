<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
} elseif($_COOKIE['id_group'] != 1) {
    header("Location: ./index.php");
}

require_once("./db/db.php");

$select_completed_requests = mysqli_query($connect, "SELECT * FROM `requests` WHERE `ready`='2'");
$select_completed_requests = mysqli_fetch_all($select_completed_requests);
$total_completed_requests = count($select_completed_requests);

$statistics = array();

foreach($select_completed_requests as $completed_request) {
    $type = $completed_request[4];
    if(isset($statistics[$type])) {
        $statistics[$type]++;
    } else {
        $statistics[$type] = 1;
    }
}

// print_r($statistics);

$select_completion_time = mysqli_query($connect, "SELECT * FROM `completion_time`");
$select_completion_time = mysqli_fetch_all($select_completion_time);

$total_duration = 0;
foreach($select_completion_time as $completion_time) {
    $start_time = strtotime($completion_time[2]);
    $end_time = strtotime($completion_time[3]);
    $duration = $end_time - $start_time;
    $total_duration += $duration;
}

$average_duration = ($total_completed_requests > 0) ? ($total_duration / $total_completed_requests) : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика</title>
</head>
<body>
    <a href="./index.php">Назад</a>
    <h2>Статистика</h2>
    <p>Количество выполненных заявок - <span><?= $total_completed_requests ?></span></p>
    <p>Среднее время выполнения заявки - <?= gmdate("H:i:s", $average_duration) ?></p>
    <p>
        Статистика по типам неисправностей: 
        <ul>
            <?php
                foreach($statistics as $type => $count) {
                    $select_type_of_faults = mysqli_query($connect, "SELECT * FROM `type_of_fault` WHERE `id`='$type'");
                    $select_type_of_faults = mysqli_fetch_assoc($select_type_of_faults);
                    $type = $select_type_of_faults['name_type'];
                    ?>
                    <li><strong>Тип:</strong> <span><?= $type ?></span> | <strong>Количество:</strong> <span><?= $count ?></span></li>
            <?php }?>
        </ul>
    </p>
</body>
</html>