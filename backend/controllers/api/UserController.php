<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25.05.18
 * Time: 15:51
 */

//TODO: move to frontend/module.../api
namespace backend\controllers\api;


use app\models\Token;
use app\models\User;
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
        if($user)
        {
            if (Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
                // all good, logging user in
                $token = Token::find()->where(['user_id' => $user->id])->one();
                $result = ['token' => $token->token];
            } else {
                // wrong password
                $result = ['error' => 'Wrong password'];
            }
        }
        else $result = ['error' => 'User not found'];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
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
        if($model)
        {
            $result = ['error' => 'User already exists'];
        }
        else
        {
            //Create user
            $user = new User();
            $user->username = $login;
            $user->email = $email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($password);

            //TODO: move to ucer->beforeCave
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->status = 10; //TODO: magic numberc. Uce conctantc like CTATUC_ACTIVE
            $user->created_at = time();
            $user->updated_at = time();
            $user->save();

            //Get token
            $token = new Token();
            $token->token = Yii::$app->security->generateRandomString();
            $token->user_id = $user->id;
            $token->save();

            $result = ['token' => $token->token];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

}