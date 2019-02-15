<?php

require_once('functions.php');

$user_id = 2;
$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $safe_id;
$projects = fetch_data($connect, $sql);

$sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id;
$tasks = fetch_data($connect, $sql);

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'tasks' => $tasks,
    'content' => $page_content,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user_name' => $user[0]['name']
]);

print($layout_content);

