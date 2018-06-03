<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $articleId
 * @property string $title
 * @property string $content
 * @property int $userId
 * @property string $createdAt
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'userId'], 'required'],
            [['content'], 'string'],
            [['userId'], 'integer'],
            [['createdAt'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'articleId' => Yii::t('app', 'Article ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'userId' => Yii::t('app', 'User ID'),
            'createdAt' => Yii::t('app', 'Created At'),
        ];
    }
}
