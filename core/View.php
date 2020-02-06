<?php

namespace core;

/**
 * Базовый класс реализующий представления
 *
 */
class View
{
    /**
     * @param string $path
     * @param array $data
     *
     * @throws \ErrorException
     */
    public static function render(string $path, array $data = [])
    {
    	/**
    	 * Получение url представлений
    	 *
    	 */
        $fullPath = __DIR__ . '/../app/views/' . $path . '.php';

        if (!file_exists($fullPath)) {
            throw new \ErrorException('view cannot be found');
        }

        /**
    	 * Передача параметров в представление
    	 *
    	 */
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }

        /**
    	 * Рендер
    	 *
    	 */
        include($fullPath);
    }
}
