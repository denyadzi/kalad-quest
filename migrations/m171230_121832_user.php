<?php

use yii\db\{Migration, Schema};

/**
 * Class m171230_121832_user
 */
class m171230_121832_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' UNIQUE NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'role' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
