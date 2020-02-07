<?php

/**
 * @var array $model - массив данных
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
		<div class="container">
			<table>
				<tr>
					<th><button onclick="changeAll()">Развернуть/<br>свернуть</button></th>
					<th>ID</th>
					<th>HID</th>
					<th>Наименование</th>
					<th>Адрес</th>
					<th>Телефон</th>
				</tr>
				<?= $model; ?>
			</table>
		</div>
	</div>
	<script src="/../app/assets/js/script.js"></script>
</body>
</html>