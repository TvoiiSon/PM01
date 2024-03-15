<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form action="./vendor/registration.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Телефон" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="cpassword" placeholder="Подтверждение Пароля" required>
        <input type="submit" value="Зарегистрироваться">
    </form>
    <?php
    if(empty($_SESSION['errRegistration'])) {
        echo "";
    } else {
        echo $_SESSION['errRegistration'];
    }
    session_destroy();
    ?>
    <br><br>
    <a href="./login.php">Авторизация</a>
</body>
</html>