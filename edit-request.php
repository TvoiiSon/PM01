<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php");

$id_request = $_GET['id_request'];
$id_client = $_COOKIE['id_user'];

$select_request = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id`='$id_request' AND `id_client`='$id_client'");
$select_request = mysqli_fetch_assoc($select_request);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование заявки</title>
</head>
<body>
    <h2>Название оборудование - <strong><?= $select_request['equipment'] ?></strong></h2>
    <form action="./vendor/edit-request.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
        <input type="hidden" name="id_request" value="<?= $id_request ?>">
        <input type="hidden" name="id_user" value="<?= $_COOKIE['id_user'] ?>">
        <input type="text" name="equipment" placeholder="Название оборудования" value="<?= $select_request['equipment'] ?>" required>
        <input type="text" name="type_of_fault" placeholder="Тип неисправности" value="<?= $select_request['type_of_fault'] ?>" required>
        <textarea name="description" cols="30" rows="10" placeholder="Описание проблемы" required><?= $select_request['description'] ?></textarea>
        <input type="submit" value="Обновить заявку">
    </form>
    <br><br>
    <a href="./index.php">Назад</a>
</body>
</html>