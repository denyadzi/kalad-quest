<?php

use yii\db\{Migration, Schema};

/**
 * Class m171230_122231_quest
 */
class m171230_122231_quest extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%quests}}', [
            '[[id]]' => Schema::TYPE_PK,
            '[[task]]' => Schema::TYPE_TEXT . ' NOT NULL',
            '[[key]]' => Schema::TYPE_STRING . ' NOT NULL',
            '[[passed]]' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%quests}}');
    }
}
