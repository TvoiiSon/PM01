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
    <title>Главная</title>
</head>
<body>
    <a href="./logout.php">Выйти</a>
    <?php 
        if($_COOKIE['id_group'] == 1){ ?>
            <div class="container">
                <div class="container-left">
                    <h2>Зарегистрировать Сотрудника</h2>
                    <form action="./vendor/create-worker.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
                        <input type="text" name="login" placeholder="Логин" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="phone" placeholder="Телефон" required>
                        <input type="password" name="password" placeholder="Пароль" required>
                        <input type="password" name="cpassword" placeholder="Подтверждение Пароля" required>
                        <input type="submit" value="Зарегистрироваться">
                    </form>
                    <?php
                        if(empty($_SESSION['errCreateWorker'])) {
                            echo "";
                        } else {
                            echo $_SESSION['errCreateWorker'];
                        }
                        session_destroy();
                    ?>
                </div>
                <div class="container-right">
                    <h2>Сотрудники</h2>
                    <?php 
                        $select_workerks = mysqli_query($connect, "SELECT * FROM `users` WHERE `idgroup`='2'");
                        $select_workerks = mysqli_fetch_all($select_workerks);
                    ?>
                    <ul>
                        <?php foreach ($select_workerks as $worker) { ?>
                            <li>
                                <div class="li-content">
                                    <p>Логин сотрудника - <?= $worker[2] ?></p>
                                    <p>Email сотрудника - <?= $worker[4] ?></p>
                                    <p>Телефон сотрудника - <?= $worker[5] ?></p>
                                    <a href="./appoint-worker.php?id_worker=<?= $worker[0] ?>">Назначить работника</a> | 
                                    <a href="./vendor/delete-worker.php?id_worker=<?= $worker[0] ?>">Уволить</a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } elseif($_COOKIE['id_group'] == 2) { ?>
            <div class="container">
                <div class="container-left">
                    <h2>Обородования для ремонта</h2>
                    <?php 
                        $id_user = $_COOKIE['id_user'];
                        $select_equipments = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_worker`='$id_user' AND `ready`!='2'");
                        $select_equipments = mysqli_fetch_all($select_equipments);
                        if(empty($select_equipments)) {
                            echo "Оборудования для ремонта отсутсвует";
                        }
                    ?>
                    <ul>
                        <?php foreach ($select_equipments as $equipment) { 
                            if($equipment[8] == 0) {
                                $ready = "Ожидает ремонта";
                            } elseif($equipment[8] == 1) {
                                $ready = "Находится в ремонте";
                            }
                            ?>
                            <div style="display: flex; justify-content: space-between;">
                                <li>
                                    <div class="li-content">
                                        <p>Название оборудования - <span><?= $equipment[3] ?></span></p>
                                        <p>Тип неисправности - <span><?= $equipment[4] ?></span></p>
                                        <p>Описание проблемы - <span><?= $equipment[5] ?></span></p>
                                        <p>Дата создания заявки - <span><?= $equipment[6] ?></span></p>
                                        <p>Статус - <?= $ready ?></p>
                                        <br>
                                        <?php if($equipment[8] == 0) { $status = "Начать ремонт"; ?>
                                            <a href="./vendor/change-status.php?id_request=<?= $equipment[0] ?>&status=1"><?= $status ?></a>
                                        <?php } elseif($equipment[8] == 1) { $status = "Закончить ремонт"; ?>
                                            <a href="./vendor/change-status.php?id_request=<?= $equipment[0] ?>>&status=2"><?= $status ?></a>
                                            |
                                            <a href="./create-comment.php?id_request=<?= $equipment[0] ?>">Оставить комментарий</a>
                                        <?php } else {
                                            echo "Произошла ошибка";
                                        } ?>
                                    </div>
                                </li>
                                <div class="comments">
                                    <h3>Комментарии</h3>
                                    <?php 
                                    if (!empty($equipment[6])) {
                                        $comments = explode(', ', $equipment[6]);
                                        foreach ($comments as $comment) {
                                            echo "<p>$comment</p>";
                                        }
                                    } else {
                                        echo "<p>Комментариев нет</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } elseif($_COOKIE['id_group'] == 3) { ?>
            <div class="container">
                <div class="container-left">
                    <h2>Отправить заявку на ремонт</h2>
                    <form action="./vendor/create-request.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
                        <input type="hidden" name="id_user" value="<?= $_COOKIE['id_user'] ?>">
                        <input type="hidden" name="date_create" value="<?= date("Y-m-d")  ?>">
                        <input type="text" name="equipment" placeholder="Название оборудования" required>
                        <input type="text" name="type_of_fault" placeholder="Тип неисправности" required>
                        <textarea name="description" cols="30" rows="10" placeholder="Описание проблемы" required></textarea>
                        <input type="submit" value="Подать заявку">
                    </form>
                    <?php
                        if(empty($_SESSION['errCreateRequest'])) {
                            echo "";
                        } else {
                            echo $_SESSION['errCreateRequest'];
                        }
                        session_destroy();
                    ?>
                </div>
                <div class="container-right">
                    <h2>Мои заявки на ремонт</h2>
                    <?php 
                        $id_user = $_COOKIE['id_user'];
                        $select_requests = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_client`='$id_user'");
                        $select_requests = mysqli_fetch_all($select_requests);
                    ?>
                    <ul>
                        <?php foreach ($select_requests as $request) { 
                            if($request[8] == 0) {
                                $ready = "Ожидает ремонта";
                            } elseif($request[8] == 1) {
                                $ready = "Находится в ремонте";
                            } elseif($request[8] == 2) {
                                $ready = "Ремонт окончен";
                            }
                            ?>
                            <li>
                                <div class="li-content">
                                    <p>Название оборудования - <span><?= $request[3] ?></span></p>
                                    <p>Тип неисправности - <span><?= $request[4] ?></span></p>
                                    <p>Описание проблемы - <span><?= $request[5] ?></span></p>
                                    <p>Дата создания заявки - <span><?= $request[7] ?></span></p>
                                    <p>Статус - <?= $ready ?></p>
                                    <br>
                                    <?php if($request[8] == 0) { ?>
                                        <a href="./edit-request.php?id_request=<?= $request[0] ?>">Редактировать</a> | 
                                        <a href="./vendor/delete-request.php?id_request=<?= $request[0] ?>">Удалить</a>
                                    <?php } ?>
                                </div>
                                
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } else {
            echo "Неизвестная ошибка";
        }
    ?>
</body>
</html>