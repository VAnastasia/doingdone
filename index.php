<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if (isset($_GET['project_id'])) {
    $project_id = intval($_GET['project_id']);
    $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " AND project_id = " . $project_id . " ORDER BY date_create DESC";
    $tasks = fetch_data($connect, $sql);

    $sql = "SELECT id FROM projects WHERE id = '" . $project_id . "'";
    $res = mysqli_query($connect, $sql);

    if (!mysqli_num_rows($res)) {
        http_response_code(404);
        exit();
    }
}

if (isset($_GET['show_completed']) && $_GET['show_completed']) {
    $show_complete_tasks = 1;
} else {
    $show_complete_tasks = 0;
}

if (isset($_GET['task_id']) && isset($_GET['check'])) {
    $task_id = intval($_GET['task_id']);
    $sql = "SELECT * FROM tasks WHERE id = " . $task_id;
    $task = fetch_data($connect, $sql);

    if ($task[0]['state']) {
        $sql = "UPDATE tasks SET state = 0 WHERE id = " . $task_id;
    } elseif (!$task[0]['state']) {
        $sql = "UPDATE tasks SET state = 1 WHERE id = " . $task_id;
    }

    $res = mysqli_query($connect, $sql);

    if ($res) {
        header("Location: index.php");
    }
}

if (isset($_GET['time'])) {
    if ($_GET['time'] === 'today') {
        $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " AND DAY(date_do) = DAY(NOW())";
        $tasks = fetch_data($connect, $sql);
    } elseif ($_GET['time'] === 'tomorrow') {
        $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " AND DAY(date_do) = DAY(DATE_ADD(NOW(), INTERVAL 1 DAY))";
        $tasks = fetch_data($connect, $sql);
    } elseif ($_GET['time'] === 'overdue') {
        $sql = "SELECT * FROM tasks WHERE user_id = " . $user_id . " AND date_do < NOW() ORDER BY date_do ASC";
        $tasks = fetch_data($connect, $sql);
    } elseif ($_GET['time'] !== "all") {
        http_response_code(404);
        exit();
    }
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $sql = "SELECT * FROM tasks WHERE MATCH(title_task) AGAINST('" . trim($search) . "' IN BOOLEAN MODE)";
    $tasks = fetch_data($connect, $sql);
}

if (!empty($_SESSION)) {
    $page_content = include_template('index.php', [
        'tasks' => $tasks,
        'show_complete_tasks' => $show_complete_tasks
    ]);

    $layout_content = include_template('layout.php', [
        'background' => "",
        'tasks' => $tasks,
        'tasks_count' => $tasks_count,
        'content' => $page_content,
        'projects' => $projects,
        'title' => 'Дела в порядке',
        'user_name' => $user[0]['name']
    ]);

} else {
    $page_content = include_template('guest.php', []);

    $layout_content = include_template('layout.php', [
        'background' => "body-background",
        'title' => 'Дела в порядке',
        'tasks' => [],
        'tasks_count' => [],
        'content' => $page_content,
        'projects' => [],
        'user_name' => ""
    ]);
}

print($layout_content);

