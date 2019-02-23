<?php

require_once('init.php');
require_once('functions.php');
require_once('data.php');

$page_content = include_template('enter.php', []);

$layout_content = include_template('layout-reg.php', [
    'content' => $page_content,
    'title' => 'Дела в порядке | Вход'
]);

print($layout_content);
