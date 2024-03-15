<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оставить комментарий</title>
</head>
<body>
    <a href="./index.php">Назад</a>
    <h2>Оставить комментарий</h2>
    <form action="./vendor/create-comment.php" method="post">
        <input type="hidden" name="id_request" value="<?= $_GET['id_request'] ?>">
        <input type="hidden" name="id_worker" value="<?= $_COOKIE['id_user'] ?>">
        <textarea name="comment" cols="30" rows="10" placeholder="Комментарий" required></textarea>
        <br>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>