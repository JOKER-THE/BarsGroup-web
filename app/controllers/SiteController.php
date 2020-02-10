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
     * @param integer $id
     */
    public function actionUpdate(int $id) :void
    {
        
    }

    /**
     * Удаление данных конкретной Lpu
     *
     * @param integer $id
     */
    public function actionDelete(int $id) :void
    {

    }
}