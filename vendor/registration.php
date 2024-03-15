<?php
session_start();

require_once("../db/db.php");

$idgroup = 3;
$login = $_POST['login'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

$select_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
$select_user = mysqli_fetch_assoc($select_user);

if(empty($select_user)) {
    if($password != $cpassword) {
        $_SESSION['errRegistration'] = "Пароли не совпадают!";
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
    $_SESSION['errRegistration'] = "Такой пользователь уже существует!";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
