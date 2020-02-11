<?php

namespace app\services;

class ArrayObj
{
	/**
	 * Восстановление данных из дерева в массив
	 * с сохранением подмассивов children
	 *
	 * @param array $tree
	 *
	 * @return array
	 */
	public function getArray($tree) :array
	{
		$array = [];

		foreach ($tree as $key => $item) {
			array_push($array, $item);

			if(!empty($item->children)) {
				$children = $this->getArray($item->children);
				$array = array_merge($array, $children);
			}
		}

		return $array;
	}

	/**
	 * Формирует массив по принципу
	 * ключ => [ID, наименование]
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public function getIdNameAssoc($array) :array
	{
		$response = [];

		foreach ($array as $key => $item) {
			$elem = [
				'id' => $item->id,
				'name' => $item->full_name
			];

			array_push($response, $elem);
		}

		return $response;
	}
}