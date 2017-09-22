<?php

namespace app\models;

use Yii;

 
class SetPersonnel extends CardPersonnel
{
    
    public $id;
    public $card_number;
    public $card_id;
    public $name;
    public $nt_code;
    public $days;
    public $plate_car;
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_number', 'name', 'nt_code', 'days'], 'required'],
            [['card_number', 'card_id', 'nt_code', 'days'], 'integer'],
            [['name', 'plate_car'], 'string', 'max' => 50],
            [['card_number'], 'unique', 'message' => 'این کارت قبلا در سیستم ثبت شده است'],
            ['card_number', 'cardValidate'],
        ];
    }
    // CardPersonnel
    public function cardValidate($attribute)
    {
            $cardModel = $this->getCard();
            
            if(!isset($cardModel->id))
            {
                $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
            }
            else if($cardModel->card_type != 4){
                $this->addError($attribute, "این کارت به عنوان کارت پرسنلی نمیتواند ثبت شود");
            }
    }
    
    public function set_personnel()
    {
        $cardModel = Card::find()->where(['card_tag' => $this->card_number])->one();
        $personnelModel = new CardPersonnel();
        $personnelModel->card_number = $this->card_number;
        $personnelModel->card_id = $cardModel->id;
        $personnelModel->name = $this->name;
        $personnelModel->nt_code = $this->nt_code;
        $personnelModel->days = $this->days;
        $personnelModel->plate_car = $this->plate_car;
        $personnelModel->save();
        $reportPersonnelModel = new ReportPersonnel();
        $reportPersonnelModel->personnel_id = $personnelModel->id;
        $reportPersonnelModel->date_register = ''.time();
        $reportPersonnelModel->save();
        return TRUE;
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
    
    public function clearValue()
    {
        $this->card_number = "";
        $this->name = "";
        $this->nt_code = "";
        $this->days = "";
        $this->plate_car = "";
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->card_number])->one();
    }
}
