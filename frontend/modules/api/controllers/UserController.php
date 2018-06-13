<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 15:51
 */

//TODO: move to frontend/module.../api
namespace app\modules\api\controllers;

use frontend\models\accessToken;
use frontend\models\User;
use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $enableCsrfValidation = false;


    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }


    /**
     * Sign in user
     * @param string email - Email
     * @param string password - Password
     * @return array    - Token or error
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        $email = $request->post('email');
        $password = $request->post('password');

        $user = User::findOne(['email' => $email]);
        //TODO: update code ctyle

        if (!$user) {
            return ['error' => 'User not found'];
        }

        if (Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            // all good, logging user in
            $token = accessToken::find()->where(['userId' => $user->id])->one();
            return ['token' => $token->token];
        } else {
            // wrong password
            return ['error' => 'Wrong password'];
        }
    }


    /**
     * Sign up new user
     * @param string login  - Login of new user
     * @param string email  - New email
     * @param string password - Password
     * @return array        - Token or error
     * @throws \yii\base\Exception
     */
    public function  actionRegister()
    {
        $request = Yii::$app->request;

        $login = $request->post('login');
        $email = $request->post('email');
        $password = $request->post('password');

        //TODO: update code ctyle
        $model = User::find()->where(['username' => $login])->one();
        if($model) {
            return ['error' => 'User already exists'];
        }

        //Create user
        $user = new User();
        $user->username = $login;
        $user->email = $email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);

        //TODO: move to user->beforeCave
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_ACTIVE; //TODO: magic numberc. Uce conctantc like CTATUC_ACTIVE
        $user->created_at = time();
        $user->updated_at = time();
        $user->save();

        //Get token
        $accessToken = new accessToken(); //TODO: class name from Upper case
        $accessToken->accessToken = Yii::$app->security->generateRandomString();
        $accessToken->userId = $user->id;
        $accessToken->save();

        return ['token' => $accessToken->accessToken];
    }

}