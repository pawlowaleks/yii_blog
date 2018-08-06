<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26.07.18
 * Time: 15:48
 */

namespace common\models\db;


class Comment extends BaseComment
{
    /**
     * @return array
     */
    public function serializeToArray()
    {
        $serializedObject = [];
        $serializedObject['commentId']  = $this->commentId;
        $serializedObject['articleId']      = $this->articleId;
        $serializedObject['userId']    = $this->userId;
        $serializedObject['comment']     = $this->comment;
        $serializedObject['createdAt']  = $this->createdAt;
        return $serializedObject;
    }
}