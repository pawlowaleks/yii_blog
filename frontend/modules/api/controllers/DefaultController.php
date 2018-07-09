<?php

namespace app\modules\api\controllers;

use yii\web\Controller;

//TODO: may be remove?
/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
