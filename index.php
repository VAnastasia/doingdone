<?php

require_once('functions.php');

$user_id = 2;
$safe_id = intval($user_id);

$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_real_connect($link, "localhost", "root", "", "todolist");

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");

if(!$connect) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM users WHERE id = " . $safe_id;
    $result = mysqli_query($connect, $sql);

    if(!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL: " . $error);
    }
    $user = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM projects WHERE user_id = " . $safe_id;
    $result = mysqli_query($connect, $sql);

    if(!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL: " . $error);
    }
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);


    $sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id;
    $result = mysqli_query($connect, $sql);

    if(!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL: " . $error);
    }
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

}

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
    'tasks' => $tasks,
    'content' => $page_content,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user_name' => $user['name']
]);

print($layout_content);

