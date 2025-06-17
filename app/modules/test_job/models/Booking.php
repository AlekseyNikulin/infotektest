<?php

namespace app\modules\test_job\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "booking".
 *
 * @property int $id
 * @property int|null $author_id
 * @property string|null $name
 * @property int|null $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $image
 *
 * @property Authors $author
 */
class Booking extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'name', 'year', 'description', 'isbn', 'image'], 'default', 'value' => null],
            [['author_id', 'year'], 'integer'],
            [['description', 'image'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 26],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'name' => 'Name',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'image' => 'Image',
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
     * Gets query for [[BookingAuthors]].
     *
     * @return ActiveQuery
     */
    public function getBookingAuthors(): ActiveQuery
    {
        return $this->hasMany(BookingAuthors::class, ['booking_id' => 'id'])->with(['author']);
    }
}
