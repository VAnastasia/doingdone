<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(isset($_GET['project_id'])) {
    $project_id = intval($_GET['project_id']);
    $sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id . " AND project_id = " . $project_id . " ORDER BY date_create DESC";
    $tasks = fetch_data($connect, $sql);

    if(empty($tasks)) {
        http_response_code(404);
        exit();
    }
}

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

