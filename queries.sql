INSERT INTO users
SET `date_add` = NOW(), `name` = 'admin', `email` = 'admin@mail.ru', `password` = '12345';
INSERT INTO users
SET `date_add` = NOW(), `name` = 'testuser', `email` = 'testuser@mail.ru', `password` = '54321';

INSERT INTO projects (title, user_id)
VALUES ('Входящие', NULL), ('Учеба', 1), ('Работа', 2), ('Домашние дела', 2), ('Авто', 1);

INSERT INTO tasks (date_create, title, date_do, state, user_id, project_id)
VALUES (NOW(), 'Собеседование в IT компании', '01.12.2019', 0, 2, 3),
       (NOW(), 'Выполнить тестовое задание', '25.12.2019', 0, 2, 3),
       (NOW(), 'Сделать задание первого раздела', '21.12.2019', 1, 1, 2),
       (NOW(), 'Встреча с другом', '22.12.2019', 0, 1, 1),
       (NOW(), 'Купить корм для кота', NULL, 0, 2, 4),
       (NOW(), 'Заказать пиццу', NULL, 0, 2, 4);

# получить список из всех проектов для одного пользователя
SELECT title FROM projects WHERE user_id = 1;

# получить список из всех задач для одного проекта
SELECT title FROM tasks WHERE project_id = 4;

# пометить задачу как выполненную
UPDATE tasks SET state = 1 WHERE title = 'Купить корм для кота';

# обновить название задачи по её идентификатору
UPDATE tasks SET title = 'Заказать суши' WHERE id = 6;
