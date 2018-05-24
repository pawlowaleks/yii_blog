<?php

//namespace app\controllers;
namespace frontend\controllers;

use app\models\Post;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex()
    {
        $post = Post::find()->asArray()->all();

        return $this->render('index', compact('post'));

    }

    public function actionCreate()
    {
        return $this->render('create');
    }

}
