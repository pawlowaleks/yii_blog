<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.06.18
 * Time: 17:32
 */

namespace backend\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}