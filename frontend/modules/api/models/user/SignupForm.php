<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26.06.18
 * Time: 20:42
 */

namespace common\models;


use common\models\db\AccessToken;
use common\models\db\User;
use Yii;
use yii\base\Model;

//TODO: move to frontend/modules/api/models/auth

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    //TODO: save access token here

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\db\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\db\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    //TODO: separate action and serialization
    /**
     * Signs user up.
     *
     * @return string
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        //Create user
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);

        if (!$user->save()) {
            $this->addErrors($user->getErrors());
            return null;
        }

        //Create access token
        $accessToken = new AccessToken();
        $accessToken->accessToken = Yii::$app->security->generateRandomString();
        $accessToken->userId = $user->id;

        //TODO: save access token to Form
        if (!$accessToken->save()) {
            $this->addErrors($accessToken->getErrors());
            return null;
        }
        return $accessToken;
    }

    public function getAccessToken()
    {
        //TODO: remove double calling "signup". Use access token from form
        $accessToken = $this->signup();
        return ['accessToken' => $accessToken->accessToken];
    }

}