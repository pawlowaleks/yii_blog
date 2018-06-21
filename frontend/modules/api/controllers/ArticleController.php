<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 16:02
 */

namespace app\modules\api\controllers;


use common\models\db\Article;
use common\models\db\AccessToken;
use Yii;
use yii\rest\ActiveController;

class ArticleController extends BaseController
{
    public $modelClass = 'app\models\Article';

    public $enableCsrfValidation = false;


    /**
     * @api {post} /api/article/createNew Создать новую статью
     * @apiDescription Метод для создания новых статей
     * @apiName createNew
     * @apiGroup article
     *
     * @apiParam {String} title Title
     * @apiParam {String} content Content
     *
     * @apiSuccess {Integer} articleId Id созданной статьи
     */
    public function actionCreateNew()
    {
        $request = Yii::$app->request;

        $title = $request->post('title');
        $content = $request->post('content');

        //TODO: update formatting
        if (!$this->getAccess()) {

            return ['error' => 'User not found'];
        }

        // вставить новую строку данных
        $article = new Article();
        $article->title = $title;
        $article->content = $content;
        //TODO: get user id from \Yii::$app->user...
        $article->userId = \Yii::$app->user->id;
        $article->save();

        return ['articleId' => $article->userId];
    }

    /**
     * @api {get} /api/article/get Получить доступные статьи
     * @apiDescription Метод для порционной загрузки доступных статей
     * @apiName get
     * @apiGroup article
     *
     * @apiParam {Integer} [offset] Offset
     * @apiParam {Integer} [limit] Limit
     *
     * @apiSuccess {Object[]} articles Массив с сущностями Статья
     * @apiSuccess {Integer} articles.articleId ID Статьи
     * @apiSuccess {String} articles.title Заголовок статьи
     * @apiSuccess {String} articles.content Контент статьи
     * @apiSuccess {Integer} articles.createdAt Дата создания статьи
     */
    public function actionGet($limit = 20, $offset = 0)
    {
        //TODO: use serializeToArray, generae own results
        $articles = Article::find()->limit($limit)->offset($offset)->each();

        return ['articles' => $articles];
    }

    /**
     * @api {get} /api/article/getMy Получить доступные статьи авторизованного пользователя
     * @apiDescription Метод для порционной загрузки доступных статей авторизованного пользователя
     * @apiName getMy
     * @apiGroup article
     *
     * @apiParam {String} accessToken Access token
     * @apiParam {Integer} [offset] Offset
     * @apiParam {Integer} [limit] Limit
     *
     * @apiSuccess {Object[]} articles Массив с сущностями Статья
     * @apiSuccess {Integer} articles.articleId ID Статьи
     * @apiSuccess {String} articles.title Заголовок статьи
     * @apiSuccess {String} articles.content Контент статьи
     * @apiSuccess {Integer} articles.createdAt Дата создания статьи
     */
    public function actionGetMy($accessToken, $limit = 20, $offset = 0)
    {
        $model = AccessToken::find()->where(['accessToken' => $accessToken])->one();
        if (!$model) {
            return ['error' => 'User not found'];
        }
        $query = Article::find()
            ->andWhere(['userId' => $model->userId])
            ->limit($limit)
            ->offset($offset);
        $result = [];
        foreach ($query->each() as /** @var Article $article */ $article) {
            $result[] = $article->serializeToArray();
        }
        return ['articles' => $result]; //TODO: rename to articlec

    }

}