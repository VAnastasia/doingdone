<?php

require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', [
    'tasks' => $tasks_array,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'tasks' => $tasks_array,
    'content' => $page_content,
    'projects' => $projects_array,
    'title' => 'Дела в порядке',
    'user_name' => 'Имя пользователя'
]);

print($layout_content);
