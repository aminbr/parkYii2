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
/**
 * Description of CardReader
 *
 * @author Amin
 */
class SetPercent extends Model{
    
    public $tagInput;
    public $percent;
    public $typeInput;

    public function rules() {
        return [
//            [['tagInput', 'percent'], 'safe'],
            [['tagInput', 'percent'], 'required'],
            [['tagInput', 'percent'],'number'],
            [['typeInput'],'string'],
            ['tagInput', 'cardValidate'],
        ];
    }
    
    public function cardValidate($attribute)
    {
            $cardModel = $this->getCard();
            if(!isset($cardModel->id))
            {
                $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
            }
            else if($cardModel->card_type != 2){
                $this->addError($attribute, "این کارت شامل تخفیف نمی باشد");
            }
    }

    public function set_percent() 
    {
        $cardModel = Card::find()->where(['card_tag' => $this->tagInput])
                ->andWhere('')
                ->one();
        $cardModel->percent = $this->percent;
        $cardModel->update();
       
        
    }
    
    public function clearValue()
    {
        $this->tagInput = "";
        $this->percent = "";
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->attributes])
//                ->andWhere(['card_type' => 2])
                ->one();
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tagInput' => 'شماره کارت',
            'percent' => 'درصد تخفیف',
        ];
    }
}
