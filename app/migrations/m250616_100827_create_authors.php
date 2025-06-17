<?php

use yii\db\Migration;

class m250616_100827_create_authors extends Migration
{
    const TABLE = 'authors';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            table: self::TABLE,
            columns: [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
            ],
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);

        return true;
    }
}
