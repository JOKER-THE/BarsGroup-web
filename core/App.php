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
        $controller = (empty($pathParts[1])) ? 'site' : $pathParts[1];
        $action = (empty($pathParts[2])) ? 'index' : $pathParts[2];

        /**
         * Пространство имен для контроллеров и именование действий
         *
         */
        $controller = 'app\controllers\\' . ucfirst($controller) . 'Controller';
        $action = 'action' . ucfirst($action);

        /**
         * Отделение параметров
         *
         */
        $action = explode('?', $action);
        $action = $action[0];

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

        call_user_func_array([$controller, $action], $_GET);
    }
}