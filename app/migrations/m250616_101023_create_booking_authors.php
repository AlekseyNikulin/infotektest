<?php

use yii\db\Migration;

class m250616_101023_create_booking_authors extends Migration
{
    const TABLE = 'booking_authors';
    const REF_TABLE_BOOKING = 'booking';
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
                'booking_id' => $this->integer(),
                'author_id' => $this->integer(),
            ],
        );

        $this->addForeignKey(
            name: 'booking_authors_booking_fk',
            table: self::TABLE,
            columns: 'booking_id',
            refTable: self::REF_TABLE_BOOKING,
            refColumns: 'id',
            delete: 'CASCADE',
            update: 'CASCADE',
        );

        $this->addForeignKey(
            name: 'booking_authors_authors_fk',
            table: self::TABLE,
            columns: 'author_id',
            refTable: self::REF_TABLE_AUTHORS,
            refColumns: 'id',
            delete: 'CASCADE',
            update: 'CASCADE',
        );

        $this->createIndex(
            name: 'booking_authors_idx_uniq',
            table: self::TABLE,
            columns: ['booking_id', 'author_id'],
            unique: true,
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            name: 'booking_authors_booking_fk',
            table: self::TABLE,
        );

        $this->dropForeignKey(
            name: 'booking_authors_authors_fk',
            table: self::TABLE,
        );

        $this->dropIndex(
            name: 'booking_authors_idx_uniq',
            table: self::TABLE,
        );

        $this->dropTable(
            table: self::TABLE,
        );

        return true;
    }
}
