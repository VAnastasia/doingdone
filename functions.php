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

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}


/**
 * проверяет корректность даты и соответствие формату "ДД.ММ.ГГГГ"
 *
 * @param $date
 * @return bool|int
 */
function correct_format_day ($date) {
    $array = explode(".", $date);
    if (count($array) == 3) {
        $day = $array[0];
        $month = $array[1];
        $year = $array[2];
        if (strlen($day) == 2 && strlen($month) == 2 && strlen($year) == 4) {
            $correct = checkdate($month, $day, $year);
        }
    } else {
        $correct = 0;
    }
    return $correct;
}

