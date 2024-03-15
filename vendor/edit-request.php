<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");

$id_request = $_POST['id_request'];
$id_user = $_POST['id_user'];
$equipment = $_POST['equipment'];
$type_of_fault = $_POST['type_of_fault'];
$description = $_POST['description'];

mysqli_query($connect, "UPDATE `requests` SET `equipment`='$equipment', `type_of_fault`='$type_of_fault', `description`='$description' 
                    WHERE `id` = '$id_request' AND `id_client`='$id_user'");
header("Location: ../index.php");