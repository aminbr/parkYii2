<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enter_exit".
 *
 * @property integer $id
 * @property integer $card_id
 * @property string $enter_date
 * @property string $enter_time
 * @property string $enter_photo
 * @property integer $user_id
 * @property string $exit_date
 * @property string $exit_time
 * @property integer $transaction_id
 */
class EnterExit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enter_exit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'enter_date'], 'required'],
            [['card_id', 'user_id', 'transaction_id'], 'integer'],
            [['enter_date', 'enter_time', 'exit_date', 'exit_time'], 'safe'],
            [['enter_photo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'enter_date' => 'Enter Date',
            'enter_time' => 'Enter Time',
            'enter_photo' => 'Enter Photo',
            'user_id' => 'User ID',
            'exit_date' => 'Exit Date',
            'exit_time' => 'Exit Time',
            'transaction_id' => 'Transaction ID',
        ];
    }
    
    function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    function getCard() {
        return $this->hasOne(Card::className(), ['card_tag' => 'card_id']);
    }
    
    function getTransaction() {
        return $this->hasOne(Transaction::className(), ['enter_exit_id' => 'id']);
    }
    
}
