<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Назначить работника</title>
</head>
<body>
    <h2>Заявки</h2>
    <?php
        $select_requests = mysqli_query($connect, "SELECT * FROM `requests` WHERE `ready`!='2'");
        $select_requests = mysqli_fetch_all($select_requests);
    ?>
    <ul>
        <?php foreach ($select_requests as $request) { 
            if($request[8] == 0) {
                $ready = "Ожидает ремонта";
            } elseif($request[8] == 1) {
                $ready = "Находится в ремонте";
            }
            ?>
            <li>
                <div class="li-content">
                    <p>Название оборудования - <span><?= $request[3] ?></span></p>
                    <p>Тип неисправности - <span><?= $request[4] ?></span></p>
                    <p>Описание проблемы - <span><?= $request[5] ?></span></p>
                    <p>Дата создания заявки - <span><?= $request[6] ?></span></p>
                    <p>Статус - <?= $ready ?></p>
                    <br>
                    <a href="./vendor/appoint-worker.php?id_request=<?= $request[0] ?>&id_worker=<?= $_GET['id_worker'] ?>">Назначить</a>
                </div>
            </li>
        <?php } ?>
    </ul>
</body>
</html>