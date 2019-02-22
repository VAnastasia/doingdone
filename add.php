<?php

require_once('functions.php');

$user_id = 1;
$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "todolist");
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $safe_id;
$projects = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $safe_id;
$projects_user = fetch_data($connect, $sql);

$sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id;
$tasks = fetch_data($connect, $sql);

$sql = "SELECT title_project, COUNT(title_task) AS count_task FROM tasks JOIN projects ON tasks.project_id = projects.id
WHERE state = 0 GROUP BY title_project";
$tasks_count = fetch_data($connect, $sql);

$page_content = include_template('add.php', [
    'projects' => $projects
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;

    if (empty($task['name'])) {
        $errors['name'] = 'Поле обязательно для заполнения';
    }

    $count = 0;
    foreach ($projects_user as $value) {
       if ($value['title_project'] === $task['project']) {
          $count++;
       }
    }
    if (!$count) {
        $errors['project'] = "Выбран несуществующий проект";
    }


    if (!correct_format_day($task['date'])) {
        $errors['date'] = "Введите дату в формате ДД.ММ.ГГГГ";
    } elseif (strtotime($task['date']) <= strtotime("now")) {
        $errors['date'] = "Дата должна быть больше или равна текущей";
    }

    if (!($task['date'])) {
        unset($errors['date']);
    }


    if (is_uploaded_file($_FILES['preview']['tmp_name'])) {
        $file_name = $_FILES['preview']['name'];
        $file_path = $_FILES['preview']['tmp_name'];
        move_uploaded_file($file_path, __DIR__ . '/' . $file_name);
        $task['file'] = $file_name;
    } else {
        $task['file'] = "";
    }

    if (empty($errors)) {
        $sql = 'SELECT * FROM projects WHERE user_id = ' . $safe_id . ' AND title_project LIKE "' . $task['project'] . '"';
        $project_id = fetch_data($connect, $sql);
        $task['project_id'] = $project_id[0]['id'];

        $sql = 'INSERT INTO tasks (date_create, state, title_task, file, date_do, user_id, project_id) VALUES (NOW(), 0, ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connect, $sql, [ $task['name'], $task['file'], $task['date'], $safe_id, $task['project_id'] ]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /index.php");
        }

        $page_content = include_template('add.php', [
            'projects' => $projects
        ]);

    } else {
        $page_content = include_template('add.php', [
            'projects' => $projects,
            'errors' => $errors
            ]);
        }
}

$layout_content = include_template('layout.php', [
    'tasks' => $tasks,
    'tasks_count' => $tasks_count,
    'content' => $page_content,
    'projects' => $projects,
    'title' => 'Дела в порядке',
    'user_name' => $user[0]['name']
]);

print($layout_content);
