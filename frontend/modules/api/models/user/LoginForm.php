<?php
namespace common\models;

use common\models\db\AccessToken;
use common\models\db\User;
use Yii;
use yii\base\Model;

//TODO: move to frontend/modules/api/models/auth

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * @var User
     */
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    //TODO: unused? Remove
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    public function findAccessToken()
    {
        $accessToken = AccessToken::find()
            ->andWhere(['userId' => $this->_user->id]);

        if (!$accessToken->one()) {
            //Create access token
            $accessToken = new AccessToken();
            $accessToken->accessToken = Yii::$app->security->generateRandomString();
            $accessToken->userId = $this->_user->id;

            if (!$accessToken->save()) {
                $this->addErrors($accessToken->getErrors());
            }
        }
        return $accessToken;
    }

    //TODO: update naming like seriazlize...
    public function getAccessToken()
    {
        //TODO: update like SignupForm
        $accessToken = $this->findAccessToken();
        return ['accessToken' => $accessToken->accessToken];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
