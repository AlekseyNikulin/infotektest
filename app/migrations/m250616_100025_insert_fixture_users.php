<?php

use yii\db\Migration;

class m250616_100025_insert_fixture_users extends Migration
{
    const TABLE = 'user';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            self::TABLE,
            [
                'id',
                'username',
                'password',
                'authKey',
                'accessToken',
            ],
            [
                [
                    100,
                    'admin',
                    'admin',
                    'test100key',
                    '100-token',
                ],
                [
                    101,
                    'demo',
                    'demo',
                    'test101key',
                    '101-token',
                ],
            ]
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE);

        return true;
    }
}
