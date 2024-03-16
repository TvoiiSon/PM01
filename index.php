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
            | <a href="./statistic.php">Статистика</a>
            <div class="container">
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
                                    <a href="./appoint-worker.php?id_worker=<?= $worker[0] ?>">Назначить работника</a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } elseif($_COOKIE['id_group'] == 2) { ?>
            <div class="container" style="display: flex; justify-content: space-between;">
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
                            if($equipment[7] == 0) {
                                $ready = "Ожидает ремонта";
                            } elseif($equipment[7] == 1) {
                                $ready = "Находится в ремонте";
                            }
                            $id_equipment = $equipment[0];
                            $id_type_of_fault = $equipment[4];
                            $select_type_of_fault = mysqli_query($connect, "SELECT * FROM `type_of_fault` WHERE `id`='$id_type_of_fault'");
                            $select_type_of_fault = mysqli_fetch_assoc($select_type_of_fault);
                            $select_comment = mysqli_query($connect, "SELECT * FROM `comments` WHERE `id_request`='$id_equipment'");
                            $select_comment = mysqli_fetch_assoc($select_comment);
                            ?>
                            <div style="display: flex; justify-content: space-between;">
                                <li>
                                    <div class="li-content">
                                        <p>Название оборудования - <span><?= $equipment[3] ?></span></p>
                                        <p>Тип неисправности - <span><?= $select_type_of_fault['name_type'] ?></span></p>
                                        <p>Описание проблемы - <span><?= $equipment[5] ?></span></p>
                                        <p>Дата создания заявки - <span><?= $equipment[6] ?></span></p>
                                        <p>Статус - <?= $ready ?></p>
                                        <br>
                                        <?php if($equipment[7] == 0) { $status = "Начать ремонт"; ?>
                                            <a href="./vendor/change-status.php?id_request=<?= $equipment[0] ?>&status=1"><?= $status ?></a>
                                        <?php } elseif($equipment[7] == 1) { $status = "Закончить ремонт"; ?>
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
                                    if (!empty($select_comment)) {
                                        $comments = explode(', ', $select_comment['comment']);
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
                <div class="container-right">
                    <?php
                        $select_type_of_faults = mysqli_query($connect, "SELECT * FROM `type_of_fault`");
                        $select_type_of_faults = mysqli_fetch_all($select_type_of_faults);
                    ?>
                    <div>
                        <h2>Отправить заявку на ремонт</h2>
                        <form action="./vendor/create-request.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
                            <input type="hidden" name="id_user" value="<?= $_COOKIE['id_user'] ?>">
                            <input type="hidden" name="date_create" value="<?= date("Y-m-d")  ?>">
                            <input type="text" name="equipment" placeholder="Название оборудования" required>
                            <select name="type_of_fault" required>
                                <?php foreach($select_type_of_faults as $type_of_fault) { ?>
                                    <option value="<?= $type_of_fault[0] ?>"><?= $type_of_fault[1] ?></option>
                                <?php } ?>
                            </select>
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
                    <div>
                        <h2>Мои заявки на ремонт</h2>
                        <?php 
                            $id_user = $_COOKIE['id_user'];
                            $select_requests = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_client`='$id_user'");
                            $select_requests = mysqli_fetch_all($select_requests);
                        ?>
                        <ul>
                            <?php foreach ($select_requests as $request) { 
                                if($request[7] == 0) {
                                    $ready = "Ожидает ремонта";
                                } elseif($request[7] == 1) {
                                    $ready = "Находится в ремонте";
                                } elseif($request[7] == 2) {
                                    $ready = "Ремонт окончен";
                                }
                                $id_type_of_fault = $request[4];
                                $select_type_of_fault = mysqli_query($connect, "SELECT * FROM `type_of_fault` WHERE `id`='$id_type_of_fault'");
                                $select_type_of_fault = mysqli_fetch_assoc($select_type_of_fault);
                                ?>
                                <li>
                                    <div class="li-content">
                                        <p>Название оборудования - <span><?= $request[3] ?></span></p>
                                        <p>Тип неисправности - <span><?= $select_type_of_fault['name_type'] ?></span></p>
                                        <p>Описание проблемы - <span><?= $request[5] ?></span></p>
                                        <p>Дата создания заявки - <span><?= $request[6] ?></span></p>
                                        <p>Статус - <?= $ready ?></p>
                                        <br>
                                        <?php if($request[7] == 0) { ?>
                                            <a href="./edit-request.php?id_request=<?= $request[0] ?>">Редактировать</a> | 
                                            <a href="./vendor/delete-request.php?id_request=<?= $request[0] ?>">Удалить</a>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } elseif($_COOKIE['id_group'] == 3) { ?>
            <?php
                $select_type_of_faults = mysqli_query($connect, "SELECT * FROM `type_of_fault`");
                $select_type_of_faults = mysqli_fetch_all($select_type_of_faults);
            ?>
            <div class="container">
                <div class="container-left">
                    <h2>Отправить заявку на ремонт</h2>
                    <form action="./vendor/create-request.php" method="post" style="display: flex; flex-direction: column; width: 350px; gap: 10px;">
                        <input type="hidden" name="id_user" value="<?= $_COOKIE['id_user'] ?>">
                        <input type="hidden" name="date_create" value="<?= date("Y-m-d")  ?>">
                        <input type="text" name="equipment" placeholder="Название оборудования" required>
                        <select name="type_of_fault" required>
                            <?php foreach($select_type_of_faults as $type_of_fault) { ?>
                                <option value="<?= $type_of_fault[0] ?>"><?= $type_of_fault[1] ?></option>
                            <?php } ?>
                        </select>
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
                            if($request[7] == 0) {
                                $ready = "Ожидает ремонта";
                            } elseif($request[7] == 1) {
                                $ready = "Находится в ремонте";
                            } elseif($request[7] == 2) {
                                $ready = "Ремонт окончен";
                            }
                            $id_type_of_fault = $request[4];
                            $select_type_of_fault = mysqli_query($connect, "SELECT * FROM `type_of_fault` WHERE `id`='$id_type_of_fault'");
                            $select_type_of_fault = mysqli_fetch_assoc($select_type_of_fault);
                            ?>
                            <li>
                                <div class="li-content">
                                    <p>Название оборудования - <span><?= $request[3] ?></span></p>
                                    <p>Тип неисправности - <span><?= $select_type_of_fault['name_type'] ?></span></p>
                                    <p>Описание проблемы - <span><?= $request[5] ?></span></p>
                                    <p>Дата создания заявки - <span><?= $request[6] ?></span></p>
                                    <p>Статус - <?= $ready ?></p>
                                    <br>
                                    <?php if($request[7] == 0) { ?>
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