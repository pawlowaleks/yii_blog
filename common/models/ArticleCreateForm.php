<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03.07.18
 * Time: 19:21
 */

namespace common\models;


use common\models\db\AccessToken;
use common\models\db\Article;
use yii\base\Model;

//TODO: move to frontend/modules/api/models/article

class ArticleCreateForm extends Model
{
    public $accessToken;
    public $title;
    public $content;

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
            return null;
        }

        // вставить новую строку данных
        $article = new Article();
        $article->title = $this->title;
        $article->content = $this->content;
        $user = \Yii::$app->user->getIdentity();
        $article->userId = $user->getId();

        return $article;
    }

    public function serializeToArray()
    {
        $query = $this->createArticle();
        if (empty($query)) {
            return null;
        }

        $query->save();
        if (!$query->save()) {
            $this->addError('article', 'Error when saving new article');
            return null;
        }
        $query->refresh();
        return  ['article' => $query->serializeToArray()];
    }
}