<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $errors = [];

    $required = ['email', 'password', 'name'];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Заполните это поле";
        }
    }

    if (filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        unset($errors['email']);
    } else {
        $errors['email'] = "Введите e-mail";
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($connect, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '" . $email . "'";
        $res = mysqli_query($connect, $sql);

        if (mysqli_num_rows($res)) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }

        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (date_add, name, email, password) VALUES (NOW(), ?, ?, ?)";
        $stmt = db_get_prepare_stmt($connect, $sql, [$form['name'], $form['email'], $password]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /index.php");
            exit();
        }
        $page_content = include_template('register.php', []);
    }

    $page_content = include_template('register.php', [
        'errors' => $errors
    ]);

} else {
    $page_content = include_template('register.php', []);
}

/*print('<pre>');
print_r($form);
print_r($errors);
print('</pre>');*/



$layout_content = include_template('layout-reg.php', [
    'content' => $page_content,
    'title' => 'Дела в порядке | Регистрация'
]);

print($layout_content);
