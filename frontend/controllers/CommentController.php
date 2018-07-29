<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 27.07.18
 * Time: 22:17
 */

namespace frontend\controllers;


use common\models\db\Comment;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
    /*
    public function actionCreate()
    {


        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->userId = Yii::$app->user->id;
            $model->save();

            echo "saved";
        }


        return true;

    }
    */

    /**
     * Displays a single Comment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();

        $user = \Yii::$app->user->getIdentity();
        $model->userId = $user->getId();


        $request = Yii::$app->request;
        $articleId = $request->get('articleId');
        if (empty($articleId)) {
            $this->addErrors("Empty articleId");
            return null;
        }
        $model->articleId = $articleId;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->commentId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}