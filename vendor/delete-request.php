<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");

$id_request = $_GET['id_request'];
$select_request = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id`='$id_request'");
$select_request = mysqli_fetch_assoc($select_request);
$id_client = $_COOKIE['id_user'];
$equipment = $select_request['equipment'];
$date = $select_request['date'];

$delete_request = mysqli_query($connect, "DELETE FROM `requests` WHERE `id_client`='$id_client' AND `equipment`='$equipment' AND `date`='$date'");
header("Location: " . $_SERVER['HTTP_REFERER']);