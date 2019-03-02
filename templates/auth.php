<h2 class="content__main-heading">Вход на сайт</h2>

<form class="form" action="auth.php" method="post">
	<div class="form__row">
		<label class="form__label" for="email">E-mail <sup>*</sup></label>

		<input class="form__input <?= (isset($errors['email']) ? "form__input--error" : ""); ?> " type="text" name="email"
					 id="email" value="<?= ($form['email'] ?? ""); ?>" placeholder="Введите e-mail">

		<p class="form__message"><?= ($errors['email'] ?? ""); ?></p>
	</div>

	<div class="form__row">
		<label class="form__label" for="password">Пароль <sup>*</sup></label>

		<input class="form__input <?= (isset($errors['password']) ? "form__input--error" : ""); ?>" type="password"
					 name="password" id="password" value="<?= ($form['password'] ?? ""); ?>" placeholder="Введите пароль">

		<p class="form__message"><?= ($errors['password'] ?? ""); ?></p>
	</div>

	<div class="form__row form__row--controls">
		<p class="error-message"><?= (!empty($errors) ? "Пожалуйста, исправьте ошибки в форме" : ""); ?></p>

		<input class="button" type="submit" name="" value="Войти">
	</div>
