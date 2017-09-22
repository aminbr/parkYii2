<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card_personnel".
 *
 * @property integer $id
 * @property string $card_number
 * @property integer $card_id
 * @property string $name
 * @property integer $nt_code
 * @property integer $days
 * @property string $plate_car
 * @property string $is_deleted
 */
class CardPersonnel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card_personnel';
    }
    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['edit'] = ['card_id', 'name', 'nt_code', 'days', 'plate_car'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_number', 'name', 'nt_code', 'days'], 'required'],
            [['card_number', 'card_id', 'nt_code', 'days', 'is_deleted'], 'integer'],
            [['name', 'plate_car'], 'string', 'max' => 50],
            ['card_number', 'cardValidate'],
        ];
    }
    
    public function cardValidate($attribute){
        
        $cardModel = $this->getCard();
        if(!isset($cardModel->id))
        {
            $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
        }
        else if($cardModel->card_type != 4){
            $this->addError($attribute, "این کارت به عنوان کارت پرسنلی نمیتواند ثبت شود");
        }
        else if($cardModel->card_type == 4){
            $personnelModel = CardPersonnel::find()->where(['card_number' => $this->card_number])->one();
            if($personnelModel){
                $this->addError($attribute, "این کارت قبلا در سیستم ثبت شده است");
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_number' => 'شماره کارت',
            'card_id' => 'Card ID',
            'name' => 'نام پرسنل',
            'nt_code' => 'شماره ملی',
            'days' => 'تعداد روزهای اعتبار',
            'plate_car' => 'شماره پلاک',
        ];
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->card_number])->one();
    }
}
