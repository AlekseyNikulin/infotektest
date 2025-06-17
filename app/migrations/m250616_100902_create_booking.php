<?php

use yii\db\Migration;

class m250616_100902_create_booking extends Migration
{
    const TABLE = 'booking';
    const REF_TABLE = 'authors';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            table: self::TABLE,
            columns: [
                'id' => $this->primaryKey(),
                'author_id' => $this->integer(),
                'name' => $this->string(),
                'year' => $this->integer(4),
                'description' => $this->text(),
                'isbn' => $this->string(26),
                'image' => $this->text(),
            ],
        );

        $this->addForeignKey(
            name: 'booking_authors_fk',
            table: self::TABLE,
            columns: 'author_id',
            refTable: self::REF_TABLE,
            refColumns: 'id',
            delete: 'CASCADE',
            update: 'CASCADE',
        );

        $this->createIndex(
            name: 'booking_year_idx',
            table: self::TABLE,
            columns: ['year'],
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            name: 'booking_year_idx',
            table: self::TABLE,
        );

        $this->dropForeignKey(
            name: 'booking_authors_fk',
            table: self::TABLE,
        );

        $this->dropTable(self::TABLE);

        return true;
    }
}
