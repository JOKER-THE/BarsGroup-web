<?php

namespace app\controllers;

use core\View;
use app\models\Lpu;

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
    	$model = new Lpu();
    	$model = $model->read();

        View::render('index', [
        	'model' => $model
        ]);
    }

    /**
     * Создание нового объекта Lpu
     *
     */
    public function actionCreate() :void
    {

    }

    /**
     * Обновление данных конкретной Lpu
     *
     */
    public function actionUpdate() :void
    {

    }

    /**
     * Удаление данных конкретной Lpu
     *
     */
    public function actionDelete() :void
    {

    }
}