<?php

namespace app\services;

class Tree
{
	/**
	 * Формирование древовидной структуры объектов
	 *
	 * @param array $arr
	 *
	 * @return array
	 */
	public function createTree(array $arr) :array
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
	public function generateTree($treeElem, $parent) :array
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
}