<?php

namespace core;

/**
 * Ядро системы
 *
 * @return void
 */
class App
{
    /**
     * Запуск проекта
     *
     * @throws \ErrorException
     */
    public static function run()
    {
        /**
         * Парсинг Url
         *
         */
        $path = $_SERVER['REQUEST_URI'];
        $pathParts = explode('/', $path);
        $controller = $pathParts[1];
        $action = $pathParts[2];

        /**
         * Пространство имен для контроллеров и именование действий
         *
         */
        $controller = 'app\controllers\\' . ucfirst($controller) . 'Controller';
        $action = 'action' . ucfirst($action);

        if (!class_exists($controller)) {
            throw new \ErrorException('Controller does not exist');
        }
        
        /**
         * Создаем объект контроллера
         *
         */
        $objController = new $controller;

        if (!method_exists($objController, $action)) {
            throw new \ErrorException('action does not exist');
        }

        $objController->$action();
    }
}