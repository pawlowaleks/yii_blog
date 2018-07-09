<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 15:51
 */

//TODO: move to frontend/module.../api
namespace app\modules\api\controllers;

use common\models\LoginForm;
use common\models\SignupForm;
use Yii;

//TODO: update all actions like UserController.actionSignup
class UserController extends BaseController
{
    public $modelClass = 'app\models\User';

    /**
     * @api {post} /api/user/login Авторизовать пользователя
     * @apiDescription Метод для авторизации существующих пользователей
     * @apiName login
     * @apiGroup user
     *
     * @apiParam {String} email E-mail
     * @apiParam {String} password Password
     *
     * @apiSuccess {String} accessTokken Токен доступа
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {

        } else {
            return var_export($model->getErrors(), true);
        }

        /*
        $model->load(Yii::$app->request->post(), '');

        if (!$model->login()) {
            return 'Error: user not found or wrong password';
        }
*/


        return $model->getAccessToken();
    }



    /**
     * @api {post} /api/user/register Зарегистрировать нового пользователя
     * @apiDescription Метод для регистрации новых пользователей
     * @apiName register
     * @apiGroup user
     *
     * @apiParam {String} login Login
     * @apiParam {String} email E-mail
     * @apiParam {String} password Password
     *
     * @apiSuccess {String} accessTokken Токен доступа
     */
    public function  actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '') && ($accessToken = $model->signup())) {
            return $accessToken;
        } else {
            //TODO: return errors in json
            return var_export($model->getErrors(), true);
        }

    }

}