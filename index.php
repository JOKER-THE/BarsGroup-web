<?php

/**
 * Режим строгой типизации
 *
 */
declare(strict_types=1);

/**
 * Подключаем автозагрузчик проекта
 *
 */
require_once __DIR__ . '/core/autoload.php';

/**
 * Запускаем проект
 *
 */
core\App::run();
