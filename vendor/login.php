<?php
session_start();
require_once("../db/db.php");

$login = $_POST['login'];
$password = $_POST['password'];

$select_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
$select_user = mysqli_fetch_assoc($select_user);

if(empty($select_user)) {
    $_SESSION['errLogin'] = "Такого пользователя не существует!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    if(password_verify($password, $select_user['password'])) {
        setcookie("id_user", $select_user['id'], time()+28800, "/");
        setcookie("id_group", $select_user['idgroup'], time()+28800, "/");
        header("Location: ../index.php");
    } else {
        $_SESSION['errLogin'] = "Пароль введен неверно!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
