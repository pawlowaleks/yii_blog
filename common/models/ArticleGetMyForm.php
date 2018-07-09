<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03.07.18
 * Time: 18:46
 */

namespace common\models;


use common\models\db\AccessToken;
use common\models\db\Article;
use yii\base\Model;

//TODO: move to frontend/modules/api/models/article


//TODO: rename to MyArticleListForm
class ArticleGetMyForm extends Model
{
    public $accessToken;
    public $limit;
    public $offset;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['accessToken', 'trim'],
            ['accessToken', 'required'],
            ['accessToken', 'string', 'min' => 2, 'max' => 255],

            ['limit', 'integer', 'min' => 1, 'max' => 1000],
            ['limit', 'default', 'value' => '20'],

            ['offset', 'integer', 'min' => 0],
            ['offset', 'default', 'value' => '0'],
        ];
    }

    /**
     * @return array|null|\yii\db\ActiveQuery
     * @throws \Throwable
     */
    public function findMyArticles()
    {
        if (!$this->validate()) {
            return null;
        }
        /**
         * @var \common\models\db\User
         */
        $user = \Yii::$app->user->getIdentity();
        if (!$user) {
            $this->addError('user', 'User not found');
            return null;
        }
        $query = Article::find()
            ->andWhere(['userId' => $user->getId()])
            ->limit($this->limit)
            ->offset($this->offset);
        return $query;
    }

    /**
     * @return array
     */
    public function serializeToArray()
    {
        $query = $this->findMyArticles();
        if (empty($query)) {
            return null;
        }
        $result = [];
        foreach ($query->each() as /** @var Article $article */ $article) {
            $result[] = $article->serializeToArray();
        }
        return  ['articles' => $result];
    }
}