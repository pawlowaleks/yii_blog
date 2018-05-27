<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 16:02
 */

namespace backend\controllers\api;


use app\models\Article;
use app\models\Token;
use Yii;
use yii\rest\ActiveController;

class ArticleController extends ActiveController
{
    public $modelClass = 'app\models\Article';

    public $enableCsrfValidation = false;



    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }


    /**
     * @param string token  - User token
     * @param string title  - Title of article
     * @param string content- Content of article
     * @return array
     */
    public function actionCreateNew()
    {
        $request = Yii::$app->request;

        $token = $request->post('token');
        $title = $request->post('title');
        $content = $request->post('content');

        //запрос
        $model = Token::find()->where(['token' => $token])->limit(1)->one();
        if($model)
        {
            // вставить новую строку данных
            $article = new Article();
            $article->title = $title;
            $article->content = $content;
            $article->user_id = $model->user_id;
            $article->save();

            $result = ['id' => $article->id];
        }
        else $result = ['error' => 'User not found'];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param int $limit    - Limit showing data
     * @param int $offset   - Offset showing data
     * @return array        - List of articles or error
     */
    public function actionGet($limit = 20, $offset = 0)
    {
        $article = Article::find()->asArray()->limit($limit)->offset($offset)->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['article' => $article];
    }

    /**
     * @param $token        - User token
     * @param int $limit    - Limit showing data
     * @param int $offset   - Offset showing data
     * @return array        - List of articles or error
     */
    public function actionGetMy($token, $limit = 20, $offset = 0)
    {
        $model = Token::find()->where(['token' => $token])->limit(1)->one();
        if($model)
        {
            $article = Article::find()->asArray()->where(['user_id' => $model->user_id])->limit($limit)->offset($offset)->all();
            $result = ['article' => $article];
        }
        else $result = ['error' => 'User not found'];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

}