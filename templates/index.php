<h2 class="content__main-heading">Список задач</h2>
<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>
<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>
    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?=($show_complete_tasks ? "checked" : ""); ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>
<table class="tasks">
    <?php foreach ($tasks as $key => $item): ?>
        <?php if (!$item['complete_task']): ?>
            <tr class="tasks__item task <?=($item['date_task'] && (strtotime("+24 hours now") > strtotime($item['date_task'])) ? "task--important" : ""); ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                        <span class="checkbox_g_text"><?=esc($item['title_task']) ; ?></span>
                    </label>
                </td>
                <td class="task__file">
                    <a class="download-link" href="#">Home.psd</a>
                </td>
                <td class="task__date"><?=esc($item['date_task']) ; ?></td>
            </tr>
            <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
        <?php elseif ($item['complete_task'] && $show_complete_tasks): ?>
            <tr class="tasks__item task task--completed">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" checked>
                        <span class="checkbox__text"><?=esc($item['title_task']) ; ?> </span>
                    </label>
                </td>
                <td class="task__date"><?=esc($item['date_task']) ; ?></td>
                <td class="task__controls">
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
