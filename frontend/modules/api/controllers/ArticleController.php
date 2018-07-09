<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 16:02
 */

namespace app\modules\api\controllers;


use common\models\ArticleCreateForm;
use common\models\ArticleGetForm;
use common\models\ArticleGetMyForm;
use common\models\db\Article;
use common\models\db\AccessToken;
use Yii;
use yii\rest\ActiveController;

//TODO: update all actions like UserController.actionSignup
class ArticleController extends BaseController
{
    public $modelClass = 'common\models\db\Article';

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
        $model = new ArticleCreateForm();
        $model->load(Yii::$app->request->post(), '');
        return $model->serializeToArray();
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
    public function actionGet()
    {
        $model = new ArticleGetForm();
        $model->load(Yii::$app->request->get(), '');
        return $model->serializeToArray();
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
    public function actionGetMy()
    {
        $model = new ArticleGetMyForm();
        $model->load(Yii::$app->request->get(), '');
        return $model->serializeToArray();
    }

}