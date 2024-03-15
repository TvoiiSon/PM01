<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");


$id_request = $_GET['id_request'];
$id_worker = $_GET['id_worker'];

mysqli_query($connect, "UPDATE `requests` SET `id_worker`='$id_worker' WHERE `id` = '$id_request'");
header("Location: ../index.php");