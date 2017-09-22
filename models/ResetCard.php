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
class ResetCard extends Model{
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
            $this->cardNumber = '';
        }
    }
            
    function save(){
        $cardModel = Card::find()->where(['card_tag' => $this->cardNumber])->one();
        $cardType = $cardModel->card_type;
        if($cardType == 3){ // delete vip
            $vipModel = new CardVip();
            $vipModel = CardVip::find()->where(['card_number' => $this->cardNumber])->one();
            $vipModel->delete();
        }
        if($cardType == 4){ // delete vip
            $personnelModel = new CardPersonnel();
            $personnelModel = CardPersonnel::find()->where(['card_number' => $this->cardNumber])->one();
            $personnelModel->delete();
        }
        $enterExitModel = EnterExit::find()->where(['card_id' => $this->cardNumber])->andWhere("exit_date =''")->one();
        if(isset($enterExitModel->id))
        {
           $enterExitModel->exit_date = time()."";
           $result = $enterExitModel->save();
           if($result)
           {
                $transactionModel = new Transaction();
                $transactionModel->enter_exit_id = $enterExitModel->id;
                $transactionModel->user_id = Yii::$app->user->id;
                $transactionModel->price = 0;
                $transactionModel->created_at = time()."";
                $transactionModel->save();
                $enterExitModel->transaction_id = $transactionModel->id;
                $enterExitModel->save();
           }
        }
        $cardModel->delete();
        $this->cardNumber = '';
        return TRUE;
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
