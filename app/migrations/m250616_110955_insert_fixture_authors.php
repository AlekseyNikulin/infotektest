<?php

use yii\db\Migration;

class m250616_110955_insert_fixture_authors extends Migration
{
    const TABLE = 'authors';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $countAuthor = 15;

        for ($i = 1; $i <= $countAuthor; $i++) {
            $this->insert(
                table: self::TABLE,
                columns: [
                    'name' => 'Автор '.$i,
                ],
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE);

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250616_110955_insert_fixture_authors cannot be reverted.\n";

        return false;
    }
    */
}
