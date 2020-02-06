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
</head>
<body>
	<div class="index-page">
		<table style="border: 1px solid grey;">
			<tr>
				<th style="border: 1px solid grey;">ID</th>
				<th style="border: 1px solid grey;">HID</th>
				<th style="border: 1px solid grey;">Наименование</th>
				<th style="border: 1px solid grey;">Адрес</th>
				<th style="border: 1px solid grey;">Телефон</th>
			</tr>
			<?= $model; ?>
		</table>
	</div>
</body>
</html>