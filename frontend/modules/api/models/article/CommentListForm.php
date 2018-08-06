<?php

use common\models\db\Comment;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.07.18
 * Time: 20:49
 */

class CommentListForm extends \yii\base\Model
{

    public $articleId;
    public $limit;
    public $offset;

    private $_comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['articleId', 'integer'],

            ['limit', 'integer', 'min' => 1, 'max' => 1000],
            ['limit', 'default', 'value' => '20'],

            ['offset', 'integer', 'min' => 0],
            ['offset', 'default', 'value' => '0'],
        ];
    }

    public function findComments()
    {
        if (!$this->validate()) {
            return null;
        }
        $query = Comment::find()->where(['articleId' => $this->articleId])->limit($this->limit)->offset($this->offset)->all();

        $this->_comment = $query;
        return $query;
    }


    public function serializeToArray()
    {
        $model = $this->_comment;
        if (empty($model)) {
            return null;
        }

        $result = [];
        foreach ($model as $comment) {
            $result[] = $comment->serializeToArray();
        }
        return  ['articles' => $result];
    }
}