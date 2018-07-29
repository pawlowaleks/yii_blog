<?php

//TODO: add namespace

use common\models\db\Article;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 16.07.18
 * Time: 23:58
 */

class ArticleListForm extends \yii\base\Model
{

    public $limit;
    public $offset;

    private $_article;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['limit', 'integer', 'min' => 1, 'max' => 1000],
            ['limit', 'default', 'value' => '20'],

            ['offset', 'integer', 'min' => 0],
            ['offset', 'default', 'value' => '0'],
        ];
    }

    public function findArticles()
    {
        if (!$this->validate()) {
            return null;
        }
        $query = Article::find()->limit($this->limit)->offset($this->offset)->all();

        $this->_article = $query;
        return $query;
    }


    public function serializeToArray()
    {
        $model = $this->_article;
        if (empty($model)) {
            return null;
        }

        $result = [];
        foreach ($model as /** @var Article $article */ $article) {
            $result[] = $article->serializeToArray();
        }
        return  ['articles' => $result];
    }
}