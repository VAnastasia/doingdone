<?php

require_once 'vendor/autoload.php';
require_once 'init.php';
require_once 'functions.php';

$transport = new Swift_SmtpTransport("smtp.mailtrap.io", 25);
$transport->setUsername("6e0937830b38bd");
$transport->setPassword("bf669a83048336");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$sql = "SELECT title_task, date_do, name, email FROM tasks JOIN users ON tasks.user_id = users.id WHERE state = 0 AND date_do != 0 AND DAY(date_do) = DAY(NOW()) AND HOUR(date_do) = HOUR(NOW()) ";
$tasks = fetch_data($connect, $sql);


if (!empty($tasks)) {
    $post_message = '';

    foreach ($tasks as $task) {
        $post_message = 'Уважаемый, ' . $task['name'] . '. У вас запланирована задача "' . $task['title_task'] . '" на ' . date_format(date_create($task['date_do']),
                'H:i d.m.Y');
        $post_address = $task['email'];
        $post_name = $task['name'];

        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");

        $message->setTo([$task['email'] => $task['name']]);
        $message->setBody($post_message, 'text/plain');
        $message->setFrom('7168785b4f-d789fc@inbox.mailtrap.io', 'Дела в порядке');

        $result = $mailer->send($message);

        if ($result) {
            print("Рассылка успешно отправлена");
        } else {
            print("Не удалось отправить рассылку: " . $logger->dump());
        }
    }
}





