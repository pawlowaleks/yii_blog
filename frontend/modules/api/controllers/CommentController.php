<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.07.18
 * Time: 20:46
 */

namespace frontend\modules\api\controllers;


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
        $model = new ArticleListForm();

        if ($model->load(Yii::$app->request->post(), '') && ($model->findArticles())) {
            return $model->serializeToArray();
        } else {

            return var_export($model->getErrors(), true);
        }
    }
}