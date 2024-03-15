<?php
session_start();
if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ../login.php");
}
require_once("../db/db.php");

$idgroup = 2;
$login = $_POST['login'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

$select_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
$select_user = mysqli_fetch_assoc($select_user);

if(empty($select_user)) {
    if($password != $cpassword) {
        $_SESSION['errCreateWorker'] = "Пароли не совпадают!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($connect, "INSERT INTO `users`
                            (`idgroup`, `login`, `password`, `email`, `phone`)
                            VALUES 
                            ('$idgroup','$login','$pass_hash','$email','$phone')
        ");
        header("Location: ../index.php");
    }
} else {
    $_SESSION['errCreateWorker'] = "Такой пользователь уже существует!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
