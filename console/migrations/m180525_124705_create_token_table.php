<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 */
class m180525_124705_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //TODO: rename table acce...Token
        $this->createTable('token', [
            'id' => $this->primaryKey(), //TODO: rename to acce...TokenId
            'token' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(), //TODO: rename to u..erId
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('token');
    }
}
