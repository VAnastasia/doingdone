<h2 class="content__main-heading">Список задач</h2>
<form class="search-form" action="index.php" method="get">
	<input class="search-form__input" type="text" name="search" value="" placeholder="Поиск по задачам">
	<input class="search-form__submit" type="submit" name="" value="Искать">
</form>
<div class="tasks-controls">
	<nav class="tasks-switch">
		<a href="index.php?time=all"
			 class="tasks-switch__item <?= (isset($_GET['time']) && $_GET['time'] === "all" ? "tasks-switch__item--active" : ""); ?> ">Все
			задачи</a>
		<a href="index.php?time=today"
			 class="tasks-switch__item <?= (isset($_GET['time']) && $_GET['time'] === "today" ? "tasks-switch__item--active" : ""); ?>">Повестка
			дня</a>
		<a href="index.php?time=tomorrow"
			 class="tasks-switch__item <?= (isset($_GET['time']) && $_GET['time'] === "tomorrow" ? "tasks-switch__item--active" : ""); ?>">Завтра</a>
		<a href="index.php?time=overdue"
			 class="tasks-switch__item <?= (isset($_GET['time']) && $_GET['time'] === "overdue" ? "tasks-switch__item--active" : ""); ?>">Просроченные</a>
	</nav>
	<label class="checkbox">
		<input class="checkbox__input visually-hidden show_completed"
					 type="checkbox" <?= ($show_complete_tasks ? "checked" : ""); ?>>
		<span class="checkbox__text">Показывать выполненные</span>
	</label>
</div>
<table class="tasks">
    <?php foreach ($tasks as $key => $item): ?>
        <?php if (!$item['state']): ?>
				<tr class="tasks__item task <?= ($item['date_do'] && (strtotime("+24 hours") > strtotime($item['date_do'])) ? "task--important" : ""); ?>">
					<td class="task__select">
						<label class="checkbox task__checkbox">
							<input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?= $item['id']; ?>">
							<span class="checkbox__text"><?= htmlspecialchars($item['title_task']); ?></span>
						</label>
					</td>
					<td class="task__file">
						<a class="<?= ($item['file'] ? "download-link" : ""); ?>" href="uploads/<?= $item['file']; ?>"
							 target="_blank"><?= htmlspecialchars($item['file']); ?></a>
					</td>
					<td class="task__date"><?= ($item['date_do'] ? date_format(date_create($item['date_do']),
                  'd.m.Y') : ""); ?></td>
				</tr>
        <?php elseif ($item['state'] && $show_complete_tasks): ?>
				<tr class="tasks__item task task--completed">
					<td class="task__select">
						<label class="checkbox task__checkbox">
							<input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?= $item['id']; ?>"
										 checked>
							<span class="checkbox__text"><?= htmlspecialchars($item['title_task']); ?> </span>
						</label>
					</td>
					<td class="task__controls"></td>
					<td class="task__date"><?= ($item['date_do'] ? date_format(date_create($item['date_do']),
                  'd.m.Y') : ""); ?></td>
				</tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
<p><?= (isset($_GET['search']) && empty($tasks) ? "Ничего не найдено по вашему запросу" : ""); ?></p>
