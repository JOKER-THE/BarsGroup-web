<?php

namespace app\controllers;

use core\View;

/**
 * Главный контроллер проекта
 *
 */
class SiteController
{
    /**
     * Отображение главной страницы
     *
     */
    public function actionIndex() :void
    {
        View::render('index');
    }
}