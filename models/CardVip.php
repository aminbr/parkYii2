<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card_vip".
 *
 * @property integer $id
 * @property integer $card_number
 * @property integer $card_id
 * @property string $name
 * @property integer $nt_code
 * @property integer $price
 * @property integer $days
 * @property string $plate_car
 * @property string $model_car
 * @property string $is_deleted
 */
class CardVip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card_vip';
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['delete'] = ['is_delete'];
        $scenarios['edit'] = ['card_id', 'name', 'nt_code', 'price', 'days', 'plate_car', 'model_car'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_number', 'card_id', 'name', 'nt_code', 'price', 'days', 'plate_car', 'model_car'], 'required'],
            [['card_number', 'card_id', 'nt_code', 'price', 'days', 'is_deleted'], 'integer'],
            [['name', 'plate_car', 'model_car'], 'string', 'max' => 50],
            [['card_number'], 'unique', 'message' => 'این کارت قبلا در سیستم ثبت شده است'],
            ['card_number', 'cardValidate'],
        ];
    }

    public function cardValidate($attribute)
    {
        $cardModel = $this->getCard();
//            die(var_dump($cardModel));
        if(!isset($cardModel->id))
        {
            $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
        }
        else if($cardModel->card_type != 3){
            $this->addError($attribute, "این کارت به عنوان کارت ویژه نمیتواند ثبت شود");
        }else if($cardModel->card_type == 3){
            $vipModel = CardVip::find()->where(['card_number' => $this->card_number])->one();
            if($vipModel){
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
            'card_number' => 'شماره کارت',
            'name' => 'نام مشتری',
            'nt_code' => 'شماره ملی',
            'price' => 'قیمت',
            'days' => 'تعداد روز های اعتبار',
            'plate_car' => 'پلاک خودرو',
            'model_car' => 'مدل خودرو',
        ];
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->card_number])->one();
    }
}
