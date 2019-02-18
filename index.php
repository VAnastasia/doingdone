<?php

require_once('functions.php');

$user_id = 3;
$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $safe_id;
$projects = fetch_data($connect, $sql);

$sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id;
$tasks = fetch_data($connect, $sql);

if(isset($_GET['project_id'])) {
    $sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id . " AND project_id = " . $_GET['project_id'];
    $tasks = fetch_data($connect, $sql);

    if(empty($tasks)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}

$sql = "SELECT title_project, COUNT(title_task) AS count_task FROM tasks JOIN projects ON tasks.project_id = projects.id
WHERE state = 0 GROUP BY title_project";
$tasks_count = fetch_data($connect, $sql);

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'tasks' => $tasks,
    'tasks_count' => $tasks_count,
    'content' => $page_content,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user_name' => $user[0]['name']
]);

print($layout_content);

