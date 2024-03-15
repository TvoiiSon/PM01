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

mysqli_query($connect, "UPDATE `requests` SET `ready`='$status' WHERE `id` = '$id_request' AND `id_worker`='$id_user'");
header("Location: ../index.php");