<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 */
class m180525_124705_create_accessToken_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //TODO: rename table accessToken
        $this->createTable('accessToken', [
            'accessTokenId' => $this->primaryKey(), //TODO: rename to accesTokenId
            'accessToken' => $this->string()->notNull(),
            'userId' => $this->integer()->notNull(), //TODO: rename to userId
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('accessToken');
    }
}
