<?php 
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");

$id_user = $_COOKIE['id_user'];
$id_request = $_GET['id_request'];
$status = $_GET['status'];

$today = date("Y-m-d H:i:s");

if($status == 1) {
    print($time_start);
    mysqli_query($connect, "INSERT INTO `completion_time` 
                            (`id_request`, `time_start`) 
                            VALUES ('$id_request', '$today');
    ");
    mysqli_query($connect, "UPDATE `requests` SET `ready`='$status' WHERE `id` = '$id_request' AND `id_worker`='$id_user'");
    header("Location: ../index.php");
} elseif($status == 2) {
    mysqli_query($connect, "UPDATE `completion_time` SET `time_stop`='$today' WHERE `id_request`='$id_request'");
    mysqli_query($connect, "UPDATE `requests` SET `ready`='$status' WHERE `id` = '$id_request' AND `id_worker`='$id_user'");
    header("Location: ../index.php");
}

