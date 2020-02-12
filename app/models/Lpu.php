<?php

namespace app\models;

use app\services\ArrayObj;
use app\services\Table;
use app\services\Tree;

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

	/**
	 * @var object $table
	 */
	public $table;

	/**
	 * @var object $arrayObj
	 */
	public $arrayObj;

	/**
	 * @var object $tree
	 */
	public $tree;

	public function __construct()
	{
		$file = $this->loadFile();

		$this->arrayObj = new ArrayObj();
		$this->table = new Table();
		$this->tree = new Tree();

		$this->file = $this->tree->createTree($file);
		$this->array = $this->arrayObj->getIdNameAssoc($file);
	}

	/**
	 * Вывод данных из lpu.json
	 *
	 */
	public function read() :string
	{
		$table = $this->table->decorate($html = '', $this->file);
		return $table;
	}

	/**
	 * Добавление объекта Lpu
	 * в lpu.json
	 *
	 */
	public function create($params)
	{
		/**
		 * Написать генератор ID
		 *
		 */
		$params["id"] = $this->getId();

		if (empty($params["hid"])) {
			$params["hid"] = null;
		} elseif ($params["hid"] == "0") {
			$params["hid"] = null;
		}

		$array = $this->arrayObj->getArray($this->file);
		$item = (object) $params;
		array_push($array, $item);

		$this->save($array);
	}

	/**
	 * Обновление данных объекта
	 * Lpu в lpu.json
	 *
	 * @param array $params
	 */
	public function update($params)
	{
		$id = (integer) $params["id"];

		if ($params["hid"] == "0") {
			$params["hid"] = null;
		}

		if ($params["hid"] == $id) {
			throw new \ErrorException('Ошибка! Элемент не может быть дочерним сам себе');
		}

		$array = $this->arrayObj->getArray($this->file);
		
		foreach ($array as $key => $item) {
			if($item->id == $id) {
				break;
			}
		}
		
		if ($item->id != $id) {
			throw new \ErrorException('Ошибка! Элемент не найден');
		} else {
			$array[$key]->id = $id;
			$array[$key]->hid = $params["hid"];
			$array[$key]->full_name = $params["full_name"];
			$array[$key]->address = $params["address"];
			$array[$key]->phone = $params["phone"];
			$this->save($array);
		}
	}

	/**
	 * Удаление объекта
	 * Lpu в lpu.json
	 *
	 * @param integer $id
	 */
	public function delete(int $id)
	{
		$array = $this->arrayObj->getArray($this->file);
		
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
	 * Генератор ID для Lpu
	 *
	 * @return integer
	 */
	private function getId() :int
	{
		$id = rand(10000000, 99999999);
		$array = $this->arrayObj->getArray($this->file);

		foreach ($array as $key => $item) {
			if($item->id == $id) {
				$this->getId();
			}
		}
		
		return $id;
	}
}
