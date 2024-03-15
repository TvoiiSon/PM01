<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");

$id_user = $_POST['id_user'];
$date_create = $_POST['date_create'];
$equipment = $_POST['equipment'];
$type_of_fault = $_POST['type_of_fault'];
$description = $_POST['description'];

echo $id_user . " " . $date_create . " " . $equipment . " " . $type_of_fault . " " . $description;

$select_request = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_client`='$id_user' AND `date`='$date_create'");
$select_request = mysqli_fetch_assoc($select_request);

if(!empty($select_request)){
    $_SESSION['errCreateRequest'] = "Данная заявка уже рассматривается администрацией!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else{
    mysqli_query($connect, "INSERT INTO `requests`
                            (`id_client`, `equipment`, `type_of_fault`, `description`, `date`)
                            VALUES 
                            ('$id_user','$equipment','$type_of_fault','$description','$date_create')
                ");
    header("Location: ../index.php");
}