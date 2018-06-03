<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "accessToken".
 *
 * @property int $accessTokenId
 * @property string $accessToken
 * @property int $userId
 */
class AccessToken extends \yii\db\ActiveRecord
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
            'accessTokenId' => Yii::t('app', 'Access Token ID'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'userId' => Yii::t('app', 'User ID'),
        ];
    }
}
