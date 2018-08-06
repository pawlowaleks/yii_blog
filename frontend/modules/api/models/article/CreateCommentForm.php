<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.08.18
 * Time: 22:36
 */

namespace frontend\modules\api\models\article;


use common\models\db\Comment;
use yii\base\Model;

class CreateCommentForm extends Model
{

    public $articleId;
    public $comment;

    /**
     * @var Comment
     */
    private $_comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['articleId', 'integer'],
            ['articleId', 'required'],

            ['content', 'string', 'min' => 1],
            ['content', 'required'],
        ];
    }


    public function createComment()
    {
        if (!$this->validate()) {
            return false;
        }

        // вставить новую строку данных
        $comment = new Comment();
        $comment->articleId = $this->articleId;
        $user = \Yii::$app->user->getIdentity();
        $comment->userId = $user->getId();
        $comment->comment = $this->comment;


        if (!$comment->save()) {
            $this->addErrors($comment->getErrors());
            return null;
        }
        $comment->refresh();
        $this->_comment = $comment;
        return true;
    }

    public function serializeToArray()
    {
        $model = $this->_comment;
        if (empty($model)) {
            return null;
        }
        return  ['comment' => $model->serializeToArray()];
    }
}