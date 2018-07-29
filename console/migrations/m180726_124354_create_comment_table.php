<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180726_124354_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'commentId' => $this->primaryKey(),
            'articleId' => $this->integer(),
            'userId'    => $this->integer(),
            'comment'   => $this->text(),
            'createdAt' => $this->timestamp()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}
