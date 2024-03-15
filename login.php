<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <form action="./vendor/login.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" value="Войти">
    </form>
    <?php
    if(empty($_SESSION['errLogin'])) {
        echo "";
    } else {
        echo $_SESSION['errLogin'];
    }
    session_destroy();
    ?>
    <br><br>
    <a href="./registration.php">Зарегистрироваться</a>
</body>
</html>