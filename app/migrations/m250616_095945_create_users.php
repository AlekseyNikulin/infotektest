<?php

use yii\db\Migration;

class m250616_095945_create_users extends Migration
{
    const TABLE = 'user';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            table: self::TABLE,
            columns: [
                'id' => $this->primaryKey(),
                'username' => $this->string(),
                'password' => $this->string(),
                'authKey' => $this->string(),
                'accessToken' => $this->string(),
            ],
        );

        $this->createIndex(
            name: 'user_username_idx',
            table: self::TABLE,
            columns: [
                'username',
            ],
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            name: 'user_username_idx',
            table: self::TABLE,
        );

        $this->dropTable(self::TABLE);

        return true;
    }
}
