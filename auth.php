<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Введите e-mail";
    }

    $email = mysqli_real_escape_string($connect, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
    $res = mysqli_query($connect, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (empty($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } elseif (empty($errors) && !$user) {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('auth.php', [
            'form' => $form,
            'errors' => $errors
        ]);
    } else {
        header("Location: index.php");
        exit();
    }

} else {
    $page_content = include_template('auth.php', []);
}

$layout_content = include_template('layout.php', [
    'background' => "",
    'content' => $page_content,
    'tasks' => [],
    'tasks_count' => [],
    'projects' => [],
    'user_name' => "",
    'title' => 'Дела в порядке | Вход'
]);

print($layout_content);
