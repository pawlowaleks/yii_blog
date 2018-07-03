<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03.07.18
 * Time: 18:21
 */

namespace common\models;


use common\models\db\Article;
use yii\base\Model;

class ArticleGetForm extends Model
{
    public $limit;
    public $offset;

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

    public function get()
    {
        if (!$this->validate()) {
            return null;
        }

        $query = Article::find()->limit($this->limit)->offset($this->offset);
        $result = [];

        foreach ($query->each() as $article) {
            $result[] = $article->serializeToArray();
        }
        return ['articles' => $result];
    }



}