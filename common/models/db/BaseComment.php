<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $commentId
 * @property int $articleId
 * @property int $userId
 * @property string $comment
 * @property string $createdAt
 */
class BaseComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['articleId', 'userId'], 'integer'],
            [['comment'], 'string'],
            [['createdAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'commentId' => 'Comment ID',
            'articleId' => 'Article ID',
            'userId' => 'User ID',
            'comment' => 'Comment',
            'createdAt' => 'Created At',
        ];
    }
}
