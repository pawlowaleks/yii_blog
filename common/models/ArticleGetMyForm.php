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

    public function getMy()
    {
        if (!$this->validate()) {
            return null;
        }

        $model = AccessToken::find()->where(['accessToken' => $this->accessToken])->one();
        if (!$model) {
            return ['error' => 'User not found'];
        }
        $query = Article::find()
            ->andWhere(['userId' => $model->userId])
            ->limit($this->limit)
            ->offset($this->offset);
        $result = [];
        foreach ($query->each() as /** @var Article $article */ $article) {
            $result[] = $article->serializeToArray();
        }
        return  ['articles' => $result]; //TODO: rename to articlec

    }

}