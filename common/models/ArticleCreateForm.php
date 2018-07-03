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
            ['accessToken', 'trim'],
            ['accessToken', 'required'],
            ['accessToken', 'string', 'min' => 2, 'max' => 255],

            ['title', 'string', 'min' => 1, 'max' => 255],
            ['title', 'required'],

            ['content', 'string', 'min' => 1],
            ['content', 'required'],
        ];
    }


    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $accessToken = AccessToken::find()->where(['accessToken' => $this->accessToken])->one();

        // вставить новую строку данных
        $article = new Article();
        $article->title = $this->title;
        $article->content = $this->content;
        $article->userId = $accessToken->userId;
        $article->save();

        $a = Article::findOne($article->articleId);

        return ['article' => $a->serializeToArray()];
    }
}