<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 15:51
 */

//TODO: move to frontend/module.../api
namespace app\modules\api\controllers;

use common\models\db\accessToken;
use common\models\db\User;
use common\models\LoginForm;
use common\models\SignupForm;
use Yii;
use yii\base\ErrorException;
use yii\rest\ActiveController;

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
        $model->load(Yii::$app->request->post(), '');

        if (!$model->login()) {
            return 'Error: user not found or wrong password';
        }



        return $model->getAccessToken();
        /*

        //TODO: incapsulate this in EmailLoginForm
        $request = Yii::$app->request;

        $email = $request->post('email');
        $password = $request->post('password');

        $user = User::findOne(['email' => $email]);
        if (!$user) {
            return ['error' => 'User not found'];
        }

        if (Yii::$app->getSecurity()->validatePassword($password, $user->passwordHash)) {
            // all good, logging user in
            $accessToken = AccessToken::find()->where(['userId' => $user->id])->one();
            return ['accessToken' => $accessToken->accessToken];
        } else {
            // wrong password
            return ['error' => 'Wrong password'];
        }
        */
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

        $model->load(Yii::$app->request->post(), '');
        return $model->signup();
        /*
        if ($model->signup()) {

            //$responseObj = [];
            //$responseObj = $model->serializeResponseToArray();
            //return $responseObj;
        } else {
            //throw new ErrorException(ModelHelper::getFirstError($model));
        }

        */

        //TODO: incapsulate this in RegistrationForm

        /*
        $request = Yii::$app->request;

        $login = $request->post('login');
        $email = $request->post('email');
        $password = $request->post('password');

        $model = User::find()->where(['username' => $login])->one();
        //TODO: update formatting
        if($model) {
            return ['error' => 'User already exists'];
        }

        //Create user
        $user = new User();
        $user->username = $login;
        $user->email = $email;
        $user->passwordHash = Yii::$app->security->generatePasswordHash($password);

        $user->save();

        //Get token
        $accessToken = new AccessToken(); //TODO: class name from Upper case
        $accessToken->accessToken = Yii::$app->security->generateRandomString();
        $accessToken->userId = $user->id;
        $accessToken->save();

        return ['token' => $accessToken->accessToken];*/
    }

}