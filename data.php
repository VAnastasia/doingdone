<?php

// массив проектов
$projects_array = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];

// массив задач
$tasks_array = [
    [
        'title_task' => 'Собеседование в IT компании',
        'date_task' => '01.12.2019',
        'category_task' => $projects_array[2],
        'complete_task' => 0
    ],

    [
        'title_task' => 'Выполнить тестовое задание',
        'date_task' => '25.12.2019',
        'category_task' => $projects_array[2],
        'complete_task' => 0
    ],

    [
        'title_task' => 'Сделать задание первого раздела',
        'date_task' => '21.12.2019',
        'category_task' => $projects_array[1],
        'complete_task' => 1
    ],

    [
        'title_task' => 'Встреча с другом',
        'date_task' => '22.12.2019',
        'category_task' => $projects_array[0],
        'complete_task' => 0
    ],

    [
        'title_task' => 'Купить корм для кота',
        'date_task' => 'Нет',
        'category_task' => $projects_array[3],
        'complete_task' => 0
    ],

    [
        'title_task' => 'Заказать пиццу',
        'date_task' => 'Нет',
        'category_task' => $projects_array[3],
        'complete_task' => 0
    ]
];
