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
                'name' => $this->string(),
                'year' => $this->integer(4),
                'description' => $this->text(),
                'isbn' => $this->string(26),
                'image' => $this->text(),
            ],
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

        $this->dropTable(self::TABLE);

        return true;
    }
}
