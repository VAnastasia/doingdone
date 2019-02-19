<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form"  action="add.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?=(isset($errors['name']) ? "form__input--error" : "");?>" type="text" name="name" id="name" placeholder="Введите название" value="<?=(isset($_POST['name']) ? $_POST['name'] : ""); ?>" >
        <p class="form__message"><?=(isset($errors['name']) ? $errors['name'] : "");?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект</label>

        <select class="form__input form__input--select <?=(isset($errors['project']) ? "form__input--error" : "");?>" name="project" id="project">
            <?php foreach ($projects as $value): ?>
                <option value="<?=$value['title_project'];?>"><?=$value['title_project'];?></option>
            <?php endforeach; ?>
        </select>
        <p class="form__message"><?=(isset($errors['project']) ? $errors['project'] : "");?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?=(isset($errors['date']) ? "form__input--error" : "");?>" type="date" name="date" id="date" placeholder="Введите дату в формате ДД.ММ.ГГГГ" value="<?=(isset($_POST['date']) ? $_POST['date'] : "");?>" >
        <p class="form__message"><?=(isset($errors['date']) ? $errors['date'] : "");?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="preview">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="preview" id="preview" value="">

            <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
