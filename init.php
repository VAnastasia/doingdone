<?php

require_once('functions.php');

$user_id = 3;
$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");
