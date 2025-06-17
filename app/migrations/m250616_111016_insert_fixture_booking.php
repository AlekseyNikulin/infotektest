<?php

use yii\db\Migration;

class m250616_111016_insert_fixture_booking extends Migration
{
    const TABLE = 'booking';
    const REF_TABLE = 'booking_authors';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $years = [2025, 2010, 2008, 2006];
        $isbnTree = 0;
        $userMaxId = 15;
        $bookingTree = 1;
        $tree = 0;

        for ($i = 1; $i <= $userMaxId; $i++) {
            $this->addBookingAuthors(
                authorId: $i,
                years: $years,
                tree: $tree,
                isbnTree: $isbnTree,
                bookingTree: $bookingTree,
            );

            if ($i === $userMaxId && $tree < 3) {
                $i = 1;
                $tree++;
            }
        }

        $tree = 0;

        for ($i = 5; $i <= 10; $i++) {
            $this->addBookingAuthors(
                authorId: $i,
                years: $years,
                tree: 1,
                isbnTree: $isbnTree,
                bookingTree: $bookingTree,
            );

            if ($i === $userMaxId && $tree < 3) {
                $i = 4;
                $tree++;
            }
        }

        $tree = 0;

        for ($i = 10; $i <= 15; $i++) {
            $this->addBookingAuthors(
                authorId: $i,
                years: $years,
                tree: 1,
                isbnTree: $isbnTree,
                bookingTree: $bookingTree,
            );

            if ($i === $userMaxId && $tree < 2) {
                $i = 9;
                $tree++;
            }
        }

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

    private function addBookingAuthors(int $authorId, array $years, int $tree, int &$isbnTree, int &$bookingTree): void
    {
        $isbn = mb_str_pad((string) $isbnTree++, 5, '0', STR_PAD_LEFT);
        $this->insert(
            table: self::TABLE,
            columns: [
                'name' => 'Книга '.($bookingTree++),
                'year' => $years[$tree],
                'isbn' => sprintf('000-0-000-%s-1', $isbn),
            ],
        );

        $this->insert(
            table: self::REF_TABLE,
            columns: [
                'booking_id' => $this->getDb()->lastInsertID,
                'author_id' => $authorId,
            ],
        );
    }
}
