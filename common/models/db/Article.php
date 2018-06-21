<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21.06.18
 * Time: 18:09
 */

namespace common\models\db;


class Article extends BaseArticle
{
    /**
     * @return array
     */
    public function serializeToArray()
    {
        $serializedObject = [];
        $serializedObject['articleId'] = $this->articleId;
        $serializedObject['title'] = $this->title;
        $serializedObject['userId'] = $this->userId;
        $serializedObject['createdAt'] = $this->createdAt;
        //TODO: add another fields
        return $serializedObject;
    }
}