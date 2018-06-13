<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 16:02
 */

namespace app\modules\api\controllers;


use frontend\models\Article;
use frontend\models\accessToken;
use Yii;
use yii\rest\ActiveController;

class ArticleController extends BaseController
{
    public $modelClass = 'app\models\Article';

    public $enableCsrfValidation = false;


    /**
     * Creates new article
     * @param string token  - User token
     * @param string title  - Title of article
     * @param string content- Content of article
     * @return array
     */
    public function actionCreateNew()
    {
        $request = Yii::$app->request;

        //TODO: improve token proceccing. Try uce BaceController, Yii auth to reduce duplicate code with token
        $title = $request->post('title');
        $content = $request->post('content');

        if(!$this->getAccess()) {
            return ['error' => 'User not found'];
        }

        // вставить новую строку данных
        $article = new Article();
        $article->title = $title;
        $article->content = $content;
        //TODO: get user id from \Yii::$app->user...
        $article->userId = \Yii::$app->user->id;
        $article->save();

        return ['id' => $article->userId];

        //TODO: DRY - do not repeat youcelf. Make bace controller for api controllerc or move thic to Module
    }

    /**
     * Getting articles
     * @param int $limit    - Limit showing data
     * @param int $offset   - Offset showing data
     * @return array        - List of articles or error
     */
    public function actionGet($limit = 20, $offset = 0)
    {
        //TODO: use serializeToArray, generae own results
        $articles = Article::find()->limit($limit)->offset($offset)->each();

        return ['articles' => $articles];
    }

    /**
     * Getting articles of current user
     * @param $accessToken        - User token
     * @param int $limit    - Limit showing data
     * @param int $offset   - Offset showing data
     * @return array        - List of articles or error
     */
    public function actionGetMy($accessToken, $limit = 20, $offset = 0)
    {
        $model = accessToken::find()->where(['accessToken' => $accessToken])->one();
        if (!$model) {
            return ['error' => 'User not found'];
        }
        //TODO: rename to articlec
        $articles = Article::find()->where(['userId' => $model->userId])->limit($limit)->offset($offset)->each();
        //TODO: do not uce asArray
        //TODO: add function $article->serializeToArray
        //TODO: do not uce all, query->each()

        return ['articles' => $articles]; //TODO: rename to articlec

    }

}