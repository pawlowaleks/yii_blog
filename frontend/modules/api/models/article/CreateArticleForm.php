<?php

namespace frontend\modules\api\models\article;

use common\models\db\Article;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.07.18
 * Time: 0:05
 */

class CreateArticleForm extends \yii\base\Model
{


    public $title;
    public $content;

    /**
     * @var Article
     */
    private $_article;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'string', 'min' => 1, 'max' => 255],
            ['title', 'required'],

            ['content', 'string', 'min' => 1],
            ['content', 'required'],
        ];
    }


    public function createArticle()
    {
        if (!$this->validate()) {
            return false;
        }

        // вставить новую строку данных
        $article = new Article();
        $article->title = $this->title;
        $article->content = $this->content;
        $user = \Yii::$app->user->getIdentity();
        $article->userId = $user->getId();

        if (!$article->save()) {
            $this->addErrors($article->getErrors());
            return null;
        }
        $article->refresh();
        $this->_article = $article;
        return true;
    }

    public function serializeToArray()
    {
        $model = $this->_article;
        if (empty($model)) {
            return null;
        }
        return  ['article' => $model->serializeToArray()];
    }
}