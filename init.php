<?php

require_once('functions.php');

session_start();

$user_id = ($_SESSION['user']['id'] ?? NULL);

$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");
