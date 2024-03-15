<?php
setcookie("id_user", null, -1, "/");
setcookie("id_group", null, -1, "/");

header("Location: ./index.php");
?>