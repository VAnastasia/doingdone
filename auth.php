<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$page_content = include_template('auth.php', []);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => [],
    'tasks_count' => [],
    'projects' => [],
    'user_name' => "",
    'title' => 'Дела в порядке | Вход'
]);

print($layout_content);
