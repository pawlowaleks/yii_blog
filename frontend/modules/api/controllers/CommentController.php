<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.07.18
 * Time: 20:46
 */

namespace frontend\modules\api\controllers;


use CommentListForm;
use frontend\modules\api\models\article\ArticleListForm;
use frontend\modules\api\models\article\CreateCommentForm;
use Yii;

class CommentController extends  BaseController
{

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
        $model = new CommentListForm();

        if ($model->load(Yii::$app->request->post(), '') && ($model->findComments())) {
            return $model->serializeToArray();
        } else {

            return var_export($model->getErrors(), true);
        }
    }

    public function actionCreate()
    {
        $model = new CreateCommentForm();

        if ($model->load(Yii::$app->request->post(), '') && ($model->createComment())) {
            return $model->serializeToArray();
        } else {

            return var_export($model->getErrors(), true);
        }
    }
}