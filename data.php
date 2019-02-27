<?php

require_once('init.php');
require_once('functions.php');


$sql = "SELECT * FROM users WHERE id = " . $user_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $user_id;
$projects = fetch_data($connect, $sql);

$sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " ORDER BY date_create DESC";
$tasks = fetch_data($connect, $sql);

$sql = "SELECT title_project, COUNT(title_task) AS count_task FROM tasks JOIN projects ON tasks.project_id = projects.id
WHERE state = 0 GROUP BY title_project";
$tasks_count = fetch_data($connect, $sql);
