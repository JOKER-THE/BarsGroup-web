<?php

namespace app\services;

class Table
{
	/**
	 * Оформление таблицы с вложенными элементами
	 *
	 * @param string $html
	 * @param array $array
	 *
	 * @return string
	 */
	public function decorate($html, $array) :string
	{
		foreach ($array as $key => $item) {
			$id = htmlentities($item->id);
			$hid = htmlentities($item->hid);
			$name = htmlentities($item->full_name);
			$address = htmlentities($item->address);
			$phone = htmlentities($item->phone);

			$html .= '<tr id="' . $id . '" name="elem' . $hid . '" hid="' . $hid . '" hidden>' .
				'<td><button name="button' . $id . '" onclick="getChild(' . $id . ')"><span data-id="'. $id .'">+</span></button></td>' .
				'<td name="' . $name . '">' . $name . '</td>' .
				'<td name="' . $address . '">' . $address . '</td>' .
				'<td name="' . $phone . '">' . $phone . '</td>' .
				'<td><a href="#" onclick="getData(' . $id . ')">Изменить</a> <a href="/site/delete?id=' . $id . '">Удалить</a></td>' .
			'</tr>';

			if (!empty($item->children)) {
				$html = $this->decorate($html, $item->children);
			}
		}

		return $html;
	}
}