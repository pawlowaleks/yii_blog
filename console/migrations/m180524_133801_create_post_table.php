<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180524_133801_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'author' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'post' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
