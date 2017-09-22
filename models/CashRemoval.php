<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cash_removal".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $removal_amount
 * @property string $removal_date
 */
class CashRemoval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cash_removal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'removal_amount', 'removal_date'], 'required'],
            [['user_id', 'removal_amount'], 'integer'],
            [['removal_date'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'removal_amount' => 'Removal Amount',
            'removal_date' => 'Removal Date',
        ];
    }
}
