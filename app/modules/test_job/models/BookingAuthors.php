<?php

namespace app\modules\test_job\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "booking_authors".
 *
 * @property int $id
 * @property int|null $booking_id
 * @property int|null $author_id
 *
 * @property Authors $author
 * @property Booking $booking
 */
class BookingAuthors extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'booking_authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['booking_id', 'author_id'], 'default', 'value' => null],
            [['booking_id', 'author_id'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['booking_id'], 'exist', 'skipOnError' => true, 'targetClass' => Booking::class, 'targetAttribute' => ['booking_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'booking_id' => 'Booking ID',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Booking]].
     *
     * @return ActiveQuery
     */
    public function getBooking(): ActiveQuery
    {
        return $this->hasOne(Booking::class, ['id' => 'booking_id']);
    }
}
