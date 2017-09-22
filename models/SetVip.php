<?php
namespace app\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\base\Model;
use app\models\Card;
use Yii;
use app\models\CardVip;
/**
 * Description of CardReader
 *
 * @author Amin
 */
class SetVip extends CardVip{
    
    public $id;
    public $card_number;
    public $name;
    public $nt_code;
    public $price;
    public $days;
    public $plate_car;
    public $model_car;

    public function rules() {
        return [
            [['card_number', 'name', 'nt_code', 'price', 'days', 'plate_car', 'model_car'], 'safe'],
            [['card_number', 'name', 'nt_code', 'price', 'days', 'plate_car', 'model_car'], 'required'],
            [['card_number', 'nt_code', 'price', 'days'],'number'],
            [['name', 'plate_car', 'model_car'],'string'],
            [['card_number'], 'unique', 'message' => 'این کارت قبلا در سیستم ثبت شده است'],
            ['card_number', 'cardValidate'],
        ];
    }
    
    public function cardValidate($attribute)
    {
        $cardModel = $this->getCard();
        if(!isset($cardModel->id))
        {
            $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
        }
        else if($cardModel->card_type != 3){
            $this->addError($attribute, "این کارت به عنوان کارت ویژه نمیتواند ثبت شود");
        }
//        else if($cardModel->card_type == 3){
//            $vipModel = CardVip::find()->where(['card_number' => $this->card_number])->one();
//            if($vipModel){
//                $this->addError($attribute, "این کارت قبلا در سیستم ثبت شده است");
//            }
//        }
    }

    public function set_vip() 
    {
        $card = Card::find()->where(['card_tag' => $this->card_number])->one();
        $vipModel = new CardVip();
        $vipModel->card_number = $this->card_number;
        $vipModel->card_id = $card->id;
        $vipModel->name = $this->name;
        $vipModel->nt_code = $this->nt_code;
        $vipModel->price = $this->price;
        $vipModel->days = $this->days;
        $vipModel->plate_car = $this->plate_car;
        $vipModel->model_car = $this->model_car;
        $vipModel->save();
        $reportVipModel = new ReportVip();
        $reportVipModel->vip_id = $vipModel->id;
        $reportVipModel->date_register = ''.time();
        $reportVipModel->save();
    }
    
    public function clearValue()
    {
        $this->card_number = "";
        $this->name = "";
        $this->nt_code = "";
        $this->price = "";
        $this->days = "";
        $this->plate_car = "";
        $this->model_car = "";
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->card_number])
                ->one();
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
}
