<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "accessToken".
 *
 * @property int $accessTokenId
 * @property string $accessToken
 * @property int $userId
 */
class BaseAccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessToken';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accessToken', 'userId'], 'required'],
            [['userId'], 'integer'],
            [['accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accessTokenId' => 'Access Token ID',
            'accessToken' => 'Access Token',
            'userId' => 'User ID',
        ];
    }
}
