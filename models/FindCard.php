<?php
namespace app\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\base\Model;
use Yii;
/**
 * Description of OpenDresser
 *
 * @author Amin
 */
class FindCard extends Model{
    public $cardNumber;
    
    public function rules() {
        return[
            ['cardNumber', 'required'],
            ['cardNumber', 'number'],
            ['cardNumber', 'cardVaditation']
        ];
    }
    
    function cardVaditation($attribute)
    {
        $cardModel = $this->getCard();
        if(!isset($cardModel->id))
        {
            $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
        }
    }
            
    function save(){
        $cardModel = $this->getCard();
        $cardType = $cardModel->card_type;
        $findType = CardType::find()->where(['id' => $cardType])->one();
        $this->cardNumber = '';
        return array(
            'cardType' => $findType->name,
        );
    }

    public function attributeLabels() {
        return [
            'cardNumber' => 'شماره کارت',
        ];
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->attributes])->one();
    }
}
