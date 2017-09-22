<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property integer $id
 * @property string $card_tag
 * @property integer $card_type
 * @property string $create_at
 * @property string $update_at
 * @property integer $status
 * @property integer $percent
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_tag', 'card_type'], 'required'],
            [['card_tag', 'card_type', 'status', 'percent'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['card_tag'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_tag' => 'شماره کارت',
            'card_type' => 'نوع کارت',
            'create_at' => 'تاریخ ساخت',
            'update_at' => 'تاریخ به روز رسانی',
            'status' => 'وضعیت',
            'percent' => 'درصد تخفیف',
        ];
    }
    
    public function clearValue()
    {
        $this->card_tag = "";
        $this->card_type = "";
    }
    
    public function getCardType()
    {
        return $this->hasOne(CardType::className(), ['id' => 'card_type']);
    }
}
