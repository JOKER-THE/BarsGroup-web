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
        $list = $model->array;
    	$model = $model->read();

        View::render('index', [
        	'model' => $model,
            'list' => $list
        ]);
    }

    /**
     * Сохранение объекта Lpu
     *
     */
    public function actionSave() :void
    {
        $params = $_POST;
        $model = new Lpu();

        if (empty($params["id"])) {
            $model->create($params);
        } else {
            $model->update($params);
        }

        header('Location: /');
    }

    /**
     * Удаление данных конкретной Lpu
     *
     * @param integer $id
     */
    public function actionDelete(int $id) :void
    {
        $model = new Lpu();
        $model->delete($id);
        
        header('Location: /');
    }
}