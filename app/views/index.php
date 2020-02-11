<?php

/**
 * @var array $model - массив данных
 */

/**
 * @var array $lsit - массив данных
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Тестовое задание | BarsGroup</title>
    <link rel="stylesheet" type="text/css" href="/../app/assets/css/style.css">
</head>
<body>
	<div class="index-page">
		<div class="nav">
			<div class="container">
				<div class="left">
					<p>Тестовое задание для Bars.Group. Часть WEB</p>
				</div>
				<div class="right">
					<button id="btn_modal_window" class="btn">Добавить LPU</button>
					<div id="modal" class="modal">
						<div class="modal_content">
							<span class="close_modal_window">×</span>
							<p>Добавить LPU<p>
							<form action="site/create" method="POST">
								<div class="form-group">
									<p>
										<small><i>Выберите главное здание (при наличии)</i></small>
										<select name="hid">
											<option value="0"></option>
											<?php foreach ($list as $key => $value) : ?>
												<option value="<?= $value['id'] ?>"><?= htmlentities($value['name']) ?></option>
											<?php endforeach; ?>
										</select>
									</p>
									<p><input type="text" name="full_name" placeholder="Наименование" required></p>
									<p><input type="text" name="address" placeholder="Адрес" required></p>
									<p><input type="text" name="phone" placeholder="Телефон"></p>
									<button class="btn" type="submit">Сохранить</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<table>
				<tr>
					<th><button onclick="changeAll()">Развернуть/<br>свернуть</button></th>
					<th>Наименование</th>
					<th>Адрес</th>
					<th>Телефон</th>
					<th>Управление</th>
				</tr>
				<?= $model; ?>
			</table>
		</div>
	</div>
	<script src="/../app/assets/js/script.js"></script>
	<script src="/../app/assets/js/modal.js"></script>
</body>
</html>