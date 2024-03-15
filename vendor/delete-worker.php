<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");

$id_worker = $_GET['id_worker'];

$delete_worker = mysqli_query($connect, "DELETE FROM `users` WHERE `id`='$id_worker'");
header("Location: " . $_SERVER['HTTP_REFERER']);