<?php

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

//функция подсчета задач
function count_item($task_list, $project) {
    $count = 0;
    foreach ($task_list as $key => $value) {
        if ($value['title_project'] == $project) {
            $count = $value['count_task'];
        }
    }
    return $count;
}

//функция фильтрации задач
function esc($str) {
    $text = strip_tags($str);

    return $text;
}

//функция для получения массива из БД
function fetch_data ($connect, $sql) {
    if(!$connect) {
        print('Ошибка подключения: ' . mysqli_connect_error());
        exit();
    }
    $result = mysqli_query($connect, $sql);

    if(!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL: " . $error);
        exit();
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}

