<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $enter_exit_id
 * @property integer $user_id
 * @property integer $price
 * @property string $date
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enter_exit_id', 'user_id', 'created_at'], 'required'],
            [['enter_exit_id', 'user_id', 'price'], 'integer'],
            [['created_at'], 'string', "max" => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enter_exit_id' => 'Enter Exit ID',
            'user_id' => 'User ID',
            'price' => 'Price',
            'created_at' => 'Date',
        ];
    }
}
