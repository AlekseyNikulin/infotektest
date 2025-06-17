<?php

use yii\db\Migration;

class m250616_163250_create_subscription extends Migration
{
    const TABLE = 'subscription';
    const REF_TABLE_USER = 'user';
    const REF_TABLE_AUTHORS = 'authors';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            table: self::TABLE,
            columns: [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->defaultValue(null),
                'author_id' => $this->integer(),
                'phone' => $this->string()
            ],
        );

        $this->addForeignKey(
            name: 'subscription_user_fk',
            table: self::TABLE,
            columns: 'user_id',
            refTable: self::REF_TABLE_USER,
            refColumns: 'id',
            delete: 'CASCADE',
            update: 'CASCADE',
        );

        $this->addForeignKey(
            name: 'subscription_author_fk',
            table: self::TABLE,
            columns: 'author_id',
            refTable: self::REF_TABLE_AUTHORS,
            refColumns: 'id',
            delete: 'CASCADE',
            update: 'CASCADE',
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            name: 'subscription_user_fk',
            table: self::TABLE,
        );

        $this->dropForeignKey(
            name: 'subscription_author_fk',
            table: self::TABLE,
        );

        $this->dropTable(
            table: self::TABLE,
        );

        return true;
    }
}
