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

	/**
	 * @var array $array - массив данных, содержащий ассоциативный массив
	 * ключ (ID) => наименование LPU
	 */
	public $array;

	public function __construct()
	{
		$file = $this->loadFile();
		$this->file = $this->createTree($file);
		$this->array = $this->getIdNameAssoc($file);
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
			$id = htmlentities($item->id);
			$hid = htmlentities($item->hid);
			$name = htmlentities($item->full_name);
			$address = htmlentities($item->address);
			$phone = htmlentities($item->phone);

			$html .= '<tr id="' . $id . '" name="elem' . $hid . '" hid="' . $hid . '" hidden>' .
				'<td><button name="button' . $id . '" onclick="getChild(' . $id . ')"><span data-id="'. $id .'">+</span></button></td>' .
				'<td>' . $name . '</td>' .
				'<td>' . $address . '</td>' .
				'<td>' . $phone . '</td>' .
				'<td><a href="/site/update?id=' . $id . '">Изменить</a> <a href="/site/delete?id=' . $id . '">Удалить</a></td>' .
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

	/**
	 * Формирует массив LPU по принципу
	 * ключ => [ID, наименование]
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	private function getIdNameAssoc($array) :array
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
