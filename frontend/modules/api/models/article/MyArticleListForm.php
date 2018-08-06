<?php

namespace frontend\modules\api\models\article;

use common\models\db\Article;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.07.18
 * Time: 0:03
 */

class MyArticleListForm extends \yii\base\Model
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
            ->offset($this->offset)
            ->all();
        $this->_article = $query;
        return $query;
    }

    /**
     * @return array
     */
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