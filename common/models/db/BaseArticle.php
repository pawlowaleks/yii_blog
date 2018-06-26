<?php

namespace common\models\db;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $articleId
 * @property string $title
 * @property string $content
 * @property int $userId
 * @property string $createdAt
 */
class BaseArticle extends ActiveRecord
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
            'articleId' => 'Article ID',
            'title' => 'Title',
            'content' => 'Content',
            'userId' => 'User ID',
            'createdAt' => 'Created At',
        ];
    }
}
