<?php

namespace app\models;

/**
 * Сущность Lpu, необходимая для получения
 * и обработкиданных из файла lpu.json
 *
 */
class Lpu
{
	/**
	 * @var array $file - массив данных из файла
	 */
	public $file;

	public function __construct()
	{
		$file = $this->loadFile();
		$this->file = $this->createTree($file);
	}

	/**
	 * Вывод данных из lpu.json
	 *
	 */
	public function read() :string
	{
		$table = $this->decorate($html = '', $this->file);
		return $table;
	}

	/**
	 * Добавление объекта Lpu
	 * в lpu.json
	 *
	 */
	public function create()
	{
		
	}

	/**
	 * Обновление данных объекта
	 * Lpu в lpu.json
	 *
	 */
	public function update()
	{
		
	}

	/**
	 * Удаление объекта
	 * Lpu в lpu.json
	 *
	 * @param integer $id
	 */
	public function delete(int $id)
	{
		$array = $this->getArray($this->file);
		
		foreach ($array as $key => $item) {
			if($item->id == $id) {
				break;
			}
		}
		
		if (!empty($item->children)) {
			throw new \ErrorException('Ошибка удаления! У структуры есть дочерние отделения');
		} else {
			unset($array[$key]);
			$this->save($array);
		}
	}

	/**
	 * Загрузка данных из файла
	 *
	 * @return array
	 */
	private function loadFile() :array
	{
		$data = file_get_contents(__DIR__ . '/../../lpu.json');
		$data = json_decode($data);
		$data = $data->LPU;

		return $data;
	}

	/**
	 * Сохранение изменений файла
	 *
	 * @param array $arr
	 */
	private function save($arr) :void
	{
		foreach ($arr as $key => $item) {
			unset($arr[$key]->children);
		}

		$arr = [
			'LPU' => array_values($arr)
		];

		$arr = (object) $arr;
		file_put_contents(__DIR__ . '/../../lpu.json', json_encode($arr));
	}

	/**
	 * Формирование древовидной структуры объектов
	 *
	 * @param array $arr
	 *
	 * @return array
	 */
	private function createTree(array $arr) :array
	{
		$parent = [];

		foreach ($arr as $key => $item) {
			$parent[$item->hid][$item->id] = $item;
		}

		$treeElem = $parent[''];
		$tree = $this->generateTree($treeElem, $parent);

		return $tree;
	}
	
	/**
	 * Генерация дерева путем добавления 
	 * дочерних элементов в родителя
	 *
	 * @param array $treeElem
	 * @param array $parent
	 *
	 * @return array
	 */
	private function generateTree($treeElem, $parent) :array
	{
 		foreach($treeElem as $key => $item) {

 			if(!isset($item->children)) {
 				$treeElem[$key]->children = array();
 			}

 			if(array_key_exists($key, $parent)) {
 				$treeElem[$key]->children = $parent[$key];
 				$this->generateTree($treeElem[$key]->children, $parent);
 			}
 		}

 		return $treeElem;
	}

	/**
	 * Оформление таблицы с вложенными элементами
	 *
	 * @param string $html
	 * @param array $array
	 *
	 * @return string
	 */
	private function decorate($html, $array) :string
	{
		foreach ($array as $key => $item) {
			$html .= '<tr id="' . $item->id . '" name="elem' . $item->hid . '" hid="' . $item->hid . '" hidden>' .
				'<td><button name="button' . $item->id . '" onclick="getChild(' . $item->id . ')"><span data-id="'. $item->id .'">+</span></button></td>' .
				'<td>' . $item->full_name . '</td>' .
				'<td>' . $item->address . '</td>' .
				'<td>' . $item->phone . '</td>' .
				'<td><a href="/site/update?id=' . $item->id . '">Изменить</a> <a href="/site/delete?id=' . $item->id . '">Удалить</a></td>' .
			'</tr>';

			if (!empty($item->children)) {
				$html = $this->decorate($html, $item->children);
			}
		}

		return $html;
	}

	/**
	 * Восстановление данных из дерева в массив
	 * с сохранением подмассивов children
	 *
	 * @param array $tree
	 *
	 * @return array
	 */
	private function getArray($tree) :array
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
}
