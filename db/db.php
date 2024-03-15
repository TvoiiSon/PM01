<?php 

$connect = mysqli_connect("localhost", "root", "", "service");

if(!$connect) {
    echo "err mysqli";
}

?>