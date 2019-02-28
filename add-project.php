<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(empty($_SESSION)) {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project = $_POST;

    if (empty($project['name'])) {
        $errors['name'] = 'Поле обязательно для заполнения';
    }

    $count = 0;
    foreach ($projects as $value) {
        if (mb_strtolower($value['title_project'], 'UTF-8') == mb_strtolower($project['name'], 'UTF-8')) {
            $count++;
        }
    }
    if ($count) {
        $errors['name'] = "Такой проект уже существует";
    }

    if (empty($errors)) {
        $sql = 'INSERT INTO projects (title_project, user_id) VALUES (?, ?)';
        $stmt = db_get_prepare_stmt($connect, $sql, [ $project['name'], $user_id ]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: index.php");
            exit();
        }

        $page_content = include_template('add.php', [
            'projects' => $projects
        ]);

    } else {
        $page_content = include_template('add-project.php', [
            'projects' => $projects,
            'project' => $project,
            'errors' => $errors
        ]);
    }
} else {
    $page_content = include_template('add-project.php', [
        'projects' => $projects
    ]);
}

$layout_content = include_template('layout.php', [
    'background' => "",
    'tasks' => $tasks,
    'tasks_count' => $tasks_count,
    'content' => $page_content,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user_name' => $user[0]['name']
]);

print($layout_content);
