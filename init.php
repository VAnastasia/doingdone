<?php

require_once('functions.php');

session_start();

$user_id = intval($_SESSION['user']['id'] ?? NULL);

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");
