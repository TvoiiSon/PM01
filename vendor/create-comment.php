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

$result = mysqli_query($connect, "SELECT `comment` FROM `comments` WHERE `id_request` = '$id_request'");
$row = mysqli_fetch_assoc($result);

if(!empty($row)) {
    $current_comment = $row['comment'];
    if (!empty($current_comment)) {
        $new_comment = $current_comment . ', ' . $comment;
    } else {
        $new_comment = $comment;
    }
    
    mysqli_query($connect, "UPDATE `comments` SET `comment`='$new_comment' WHERE `id_request` = '$id_request'");
} else {
    mysqli_query($connect, "INSERT INTO `comments` 
                            (`id_request`, `comment`) 
                            VALUES ('$id_request', '$comment')
    ");
}

header("Location: ../index.php");
