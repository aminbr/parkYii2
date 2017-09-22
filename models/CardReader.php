<?php
namespace app\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\base\Model;
use app\models\EnterExit;
use app\models\Card;
use app\models\Transaction;
use app\models\CardVip;
use Yii;
/**
 * Description of CardReader
 *
 * @author Amin
 */
class CardReader extends Model{
    public $tagInput;
    public $typeInput;

    public function rules() {
        return [
            [['tagInput', 'typeInput'], 'safe'],
            ['tagInput', 'number'],
            ['typeInput', 'string'],
            ['tagInput', 'cardValidate'],
        ];
    }
    
    public function cardValidate($attribute)
    {
        if($this->typeInput == "enter")
        {
            $cardModel = $this->getCard();
            if(!isset($cardModel->id))
            {
                $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
                $this->clearValue();
                
            }
            else{
                $enterExitModel = EnterExit::find()->where(['exit_date' => '',])
                        ->andWhere(['card_id' => $cardModel->card_tag])->one();
                if(isset($enterExitModel))
                {
                    $this->addError($attribute, "این کارت قبلا خروج نخورده است");
                    $this->clearValue();
                    
                }
                if($cardModel->card_type == 3){
                    $findVip = CardVip::find()->where(['card_id' => $cardModel->id])->orderBy('id desc')->one();
                    if(!isset($findVip))
                    {
                        $this->addError($attribute, "این کارت در بخش ویژه ثبت نشده است");
                        $this->clearValue();
                    }else{
                        $reportVipModel = ReportVip::find()->where(['vip_id' => $findVip->id])->one();
                        $validDate = time() - $reportVipModel->date_register;
                        $validDate = intval(round($validDate/60/60/24)); // تعداد روزهای گذشته از تاریخ ثبت
                        $day = $findVip->days-$validDate;
                        if($day <= 0){
                            $this->addError($attribute, "اعتبار این کارت به پایان رسیده است");
                            $this->clearValue();
                        }
                    }
                }
                if($cardModel->card_type == 4){
                    $findPersonnel = CardPersonnel::find()->where(['card_id' => $cardModel->id])->orderBy('id desc')->one();
                    if(!isset($findPersonnel))
                    {
                        $this->addError($attribute, "این کارت در بخش پرسنلی ثبت نشده است");
                        $this->clearValue();
                    }else{
                        $reportPersonnelModel = ReportPersonnel::find()->where(['personnel_id' => $findPersonnel->id])->orderBy('id desc')->one();
                        $validDate = time() - $reportPersonnelModel->date_register;
                        $validDate = intval(round($validDate/60/60/24)); // تعداد روزهای گذشته از تاریخ ثبت
                        $day = $findPersonnel->days-$validDate;
                        if($day <= 0){
                            $this->addError($attribute, "اعتبار این کارت به پایان رسیده است");
                            $this->clearValue();
                        }
                    }
                }
            }
        }
        
        if($this->typeInput == "exit")
        {
            $cardModel = $this->getCard();
            
            if(!isset($cardModel->id))
            {
                $this->addError($attribute, "کارتی با این شناسه وجود ندارد");
                $this->clearValue();
            }else{
                $enterExitModel = EnterExit::find()->where(['enter_date' => '',])
                        ->andWhere(['card_id' => $cardModel->card_tag])->one();
                if(isset($enterExitModel))
                {
                    $this->addError($attribute, "این کارت قبلا ورود نخورده است");
                    $this->clearValue();
                }
            }
        }
       
    }
    
    public function enter_car() 
    {
        $cardModel = Card::find()->where(['card_tag' => $this->tagInput])->one();
        $typeCardModel = $cardModel->card_type;
//        ========================== ENTER VIP ==========================
        if($typeCardModel == 3)
        {
            $vipModel = CardVip::find()->where(['card_number' => $this->tagInput])->orderBy('id desc')->one();
            $reportVipModel = ReportVip::find()->where(['vip_id' => $vipModel->id])->orderBy('id desc')->one();
            $validDate = time() - $reportVipModel->date_register;
            $validDate = intval(round($validDate/60/60/24)); // تعداد روزهای گذشته از تاریخ ثبت
            $plate = $vipModel->plate_car;
            if($validDate < $vipModel->days){ // اعتبار دارد
//                die(var_dump($validDate));
                $enterExitModel = new EnterExit();
                $enterExitModel->card_id = $this->tagInput;
                $enterExitModel->enter_date = time()."";
                $enterExitModel->user_id = Yii::$app->user->id;
                $enterExitModel->exit_date = '';
                $enterExitModel->enter_photo = "vip.jpeg";
                $enterExitModel->save();
                $this->clearValue();
                
                $configModel = SettingSys::find()->one();
                $addressDisplay = $configModel->ip;
                $ch = curl_init($addressDisplay."/1f");
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 2);
                curl_exec($ch);
                curl_close($ch);
                return TRUE;
            }
            else
            {
                $this->clearValue();
                return array(
                    'type' => $typeCardModel,
                    'days' => 0,
                    'price' => 'not found',
                );
            }
        }
        else if($typeCardModel == 4)
        {
            $personnelModel = CardPersonnel::find()->where(['card_number' => $this->tagInput])->orderBy('id desc')->one();
            $reportPersonnelModel = ReportPersonnel::find()->where(['personnel_id' => $personnelModel->id])->orderBy('id desc')->one();
            $validDate = time() - $reportPersonnelModel->date_register;
            $validDate = intval(round($validDate/60/60/24)); // تعداد روزهای گذشته از تاریخ ثبت
            $plate = $personnelModel->plate_car;
            if($validDate < $personnelModel->days){ // اعتبار دارد
                $enterExitModel = new EnterExit();
                $enterExitModel->card_id = $this->tagInput;
                $enterExitModel->enter_date = time()."";
                $enterExitModel->user_id = Yii::$app->user->id;
                $enterExitModel->exit_date = '';
                $enterExitModel->enter_photo = "personnel.jpeg";
                $enterExitModel->save();
                $this->clearValue();
                
                $configModel = SettingSys::find()->one();
                $addressDisplay = $configModel->ip;
                $ch = curl_init($addressDisplay."/1f");
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 2);
                curl_exec($ch);
                curl_close($ch);
                return TRUE;
            }
            else
            {
                $this->clearValue();
                return array(
                    'type' => $typeCardModel,
                    'days' => 0,
                    'price' => 'not found',
                );
            }
        }
        else if($typeCardModel == 1 || $typeCardModel == 2){
//        ========================== ENTER NORMAL ==========================
            $enterExitModel = new EnterExit();
            $enterExitModel->card_id = $this->tagInput;
            $enterExitModel->enter_date = time()."";
            $enterExitModel->user_id = Yii::$app->user->id;
            $enterExitModel->exit_date = '';
            $photo_name = "pic".time()."_enter.jpeg";
            $str = Yii::$app->utility->save_pic($photo_name);
            
            if($str == TRUE)
            {
//                die(var_dump('yyyyyyyyyyy'));
                $enterExitModel->enter_photo = $photo_name;
            }else{
//                die(var_dump('nnnnnnnnnnn'));
                $enterExitModel->enter_photo = "default.jpeg";
            }
            $enterExitModel->save();
            $this->clearValue();
            
            $configModel = SettingSys::find()->one();
            $addressDisplay = $configModel->ip;
            $ch = curl_init($addressDisplay."/1f");
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 2);
            curl_exec($ch);
            curl_close($ch);
            return TRUE;
        }
    }
    
    public function exit_car() {
        $cardModel = $this->getCard();
        $type = $cardModel->card_type;
        if(!isset($cardModel->id))
        {
             $this->addError("tagInput", "کارتی با این وجود ندارد");
             $this->clearValue();
        }
        
        $enterExitModel = EnterExit::find()
                ->where(['card_id' => $cardModel->card_tag])
                ->andWhere("exit_date =''")->one();
        if(!isset($enterExitModel->id))
        {
           $this->addError("tagInput", "این کارت هنوز وارد نشده است");
           $this->clearValue();
        }
        else{ 
            $cardModel = Card::find()->where(['card_tag' => $this->tagInput])->one();
            $typeCardModel = $cardModel->card_type;
            
            $enterExitModel->exit_date = time()."";
            $result = $enterExitModel->save();
            if($result){
                // check Public card & Percent Card
                
                if($type == 1 || $type == 2){
                    $price = Yii::$app->utility->compute($enterExitModel
                            ->enter_date, $enterExitModel->exit_date, $cardModel->percent);
                    $day = '';
                    $plate = '';
                }
                // check Vip Card
                else if($type == 3){
                    $price = 0;
                    $vipModel = CardVip::find()->where(['card_number' => $this->tagInput])->orderBy('id desc')->one();
                    $plate = $vipModel->plate_car;
                    $reportVipModel = ReportVip::find()->where(['vip_id' => $vipModel->id])->orderBy('id desc')->one();
                    $validDate = time() - $reportVipModel->date_register;
                    $validDate = intval(round($validDate/60/60/24)); // تعداد روزهای گذشته از تاریخ ثبت
                    $day = $vipModel->days-$validDate;
                }else if($type == 4){
                    $price = 0;
                    $personnelModel = CardPersonnel::find()->where(['card_number' => $this->tagInput])->orderBy('id desc')->one();
                    $plate = $personnelModel->plate_car;
                    $reportPersonnelModel = ReportPersonnel::find()->where(['personnel_id' => $personnelModel->id])->orderBy('id desc')->one();
                    $validDate = time() - $reportPersonnelModel->date_register;
                    $validDate = intval(round($validDate/60/60/24)); // تعداد روزهای گذشته از تاریخ ثبت
                    $day = $personnelModel->days-$validDate;
                }
                
                $transactionModel = new Transaction();
                $transactionModel->enter_exit_id = $enterExitModel->id;
                $transactionModel->user_id = Yii::$app->user->id;
                $transactionModel->price = $price;
                $transactionModel->created_at = time()."";
                $transactionModel->save();
                $enterExitModel->transaction_id = $transactionModel->id;
                $enterExitModel->save();
                $park_time = $enterExitModel->exit_date - $enterExitModel->enter_date;
                $this->clearValue();
                
                $ipConfig = $this->getIp();
                $addressDisplay = $ipConfig->ip;
                $addressDisplay2 = $ipConfig->ip2;
                if($price == 0){
                    $price = 'a';
                }
//                die(var_dump($addressDisplay));
                $ch = curl_init($addressDisplay."/".$price);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                curl_exec($ch);
                curl_close($ch);
                
                $ch = curl_init($addressDisplay2."/".$price);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                curl_exec($ch);
                curl_close($ch);
                if($price == 'a')
                    $price = 0;
                
                return array(
                    'price' => $price,
                    'park_time' => $park_time,
                    'type' => $typeCardModel,
                    'days' => $day,
                    'plateVip' => $plate,
                );
            }
        }
    }    
    
    public function getIp() {
        $configModel = \app\models\SettingSys::find()->one();
        return $configModel;
    }
    
    public function getCard() {
        return $cardModel = Card::find()->where(['card_tag' => $this->attributes])->one();
    }
    
    public function clearValue()
    {
        $this->tagInput = "";
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagInput' => 'شماره کارت',
        ];
    }
}
