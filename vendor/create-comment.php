<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}

require_once("../db/db.php");

$id_request = $_POST['id_request'];
$id_worker = $_POST['id_worker'];
$comment = $_POST['comment'];

$result = mysqli_query($connect, "SELECT `comment` FROM `requests` WHERE `id` = '$id_request' AND `id_worker`='$id_worker'");
$row = mysqli_fetch_assoc($result);
$current_comment = $row['comment'];

if (!empty($current_comment)) {
    $new_comment = $current_comment . ', ' . $comment;
} else {
    $new_comment = $comment;
}

mysqli_query($connect, "UPDATE `requests` SET `comment`='$new_comment' WHERE `id` = '$id_request' AND `id_worker`='$id_worker'");

header("Location: ../index.php");
