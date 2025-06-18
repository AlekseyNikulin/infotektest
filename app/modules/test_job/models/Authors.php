<?php

namespace app\modules\test_job\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Booking[] $bookings
 */
class Authors extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'default', 'value' => null],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getBookings(): ActiveQuery
    {
        return $this->hasMany(Booking::class, ['id' => 'booking_id'])
            ->viaTable('booking_authors', ['author_id' => 'id']);
    }
}
