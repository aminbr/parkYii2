<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property integer $input_price
 * @property integer $input_hour
 * @property integer $capacity
 * @property integer $rounding_price
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_price', 'input_hour', 'capacity', 'rounding_price', 'free_time'], 'required', 'message' => 'فیلد "{attribute}" نباید خالی باشد'],
            [['input_price', 'input_hour', 'capacity', 'rounding_price', 'free_time'], 'integer', 'message' => 'فیلد "{attribute}" از نوع عدد میباشد'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'input_price' => '(قیمت ورودی(تومان',
            'input_hour' => '(قیمت هر ساعت(تومان',
            'capacity' => 'ظرفیت پارکینگ',
            'rounding_price' => '(مقدار رند کردن قیمت(تومان',
            'free_time' => 'زمان محدودیت',
        ];
    }
}
