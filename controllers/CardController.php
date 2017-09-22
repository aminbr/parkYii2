<?php
namespace app\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\Controller;
use app\models\Card;
use Yii;
use app\models\CardType;
use yii\helpers\ArrayHelper;
use app\models\SetPercent;
use app\models\SetVip;
use app\models\ResetCard;
use app\models\SetPersonnel;
use app\models\CardVip;
use app\models\ReportVip;
use app\models\CardPersonnel;
use app\models\ReportPersonnel;
/**
 * Description of CardController
 *
 * @author amin
 */
class CardController extends Controller{
    
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['createcard', 'setcard'],
                'rules' =>[
                    [
                        'actions' => ['createcard', 'setcard',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function(){
                            $level = Yii::$app->user->identity->level;
                            if($level == 3){
                                return TRUE;
                            }else if($level == 2){
                                return FALSE;
                            }else if($level == 1){
                                return FALSE;
                            }else if($level == 8){
                                return TRUE;
                            }
                        },
                    ]
                ]
            ]
        ];
    }
    //put your code here
    public function actionCreatecard()
    {
        $cardtypeModel = CardType::find()->all();
        $cardtypeArray = ArrayHelper::map($cardtypeModel, 'id', 'name');
        $cardModel = new Card;
        if($cardModel->load(Yii::$app->request->post()) && $cardModel->validate()){
            $cardModel->create_at = "".time();
            $cardModel->status = 1;
            $cardModel->save();
            $cardModel->clearValue();
        }
        return $this->render('createcard', [
            'cardtypeArray' => $cardtypeArray,
            'cardModel' => $cardModel,
        ]);
    }
    public function actionSetpercent()
    {
        $setCard = new SetPercent();
        if($setCard->load(Yii::$app->request->post()) && $setCard->validate())
        {
            $setCard->set_percent();
            $setCard->clearValue();
        }
        return $this->render('setpercent', [
            'setCard' => $setCard,
        ]);
    }
    
    public function actionSetvip()
    {
        $setVip = new SetVip();
        if($setVip->load(Yii::$app->request->post()) && $setVip->validate()){
            $setVip->set_vip();
            $setVip->clearValue();
            
        }
        return $this->render('setvip', [
            'setVip' => $setVip,
        ]);
    }
    
    public function actionSetpersonnel()
    {
        $cardPersonnelModel = new SetPersonnel();
        if($cardPersonnelModel->load(Yii::$app->request->post()) && $cardPersonnelModel->validate()){
            $cardPersonnelModel->set_personnel();
            $cardPersonnelModel->clearValue();
        }
        return $this->render('setpersonnel', [
            'cardPersonnelModel' => $cardPersonnelModel,
        ]);
    }
    
    public function actionResetcard() {
        $cardModel = new ResetCard();
        if($cardModel->load(\Yii::$app->request->post()) && $cardModel->validate())
        {
            $result = $cardModel->save();
            if($result)
            {
                Yii::$app->session->setFlash("success", '100000');
            }
        }
        return $this->render('resetcard', [
            'cardModel' => $cardModel,
        ]);
    }
    
    public function actionEditvip($id)
    {
        if(isset($id)){
            $vipModel = CardVip::findOne($id);
            $numberCard = $vipModel->card_number;
            if($vipModel->load(Yii::$app->request->post())){
                if($vipModel->card_number == $numberCard)
                {
                    $vipModel->setScenario('edit');
                }
            }
            if($vipModel->load(Yii::$app->request->post()) && $vipModel->validate()){
                $vipModel->save();
//                $reportVipModel = new ReportVip();
//                $reportVipModel->vip_id = $vipModel->id;
//                $reportVipModel->date_register = ''.time();
//                $reportVipModel->save();
            }
            return $this->render('editvip',[
                'vipModel' => $vipModel,
                'type' => 'edit',
            ]);
        }
    }
    
    public function actionUpdatevip($id)
    {
        if(isset($id)){
            $vipModel = CardVip::findOne($id);
            $numberCard = $vipModel->card_number;
            if($vipModel->load(Yii::$app->request->post())){
                if($vipModel->card_number == $numberCard)
                {
                    $vipModel->setScenario('edit');
                }
            }
            if($vipModel->load(Yii::$app->request->post()) && $vipModel->validate()){
                $vipModel->save();
                $reportVipModel = new ReportVip();
                $reportVipModel->vip_id = $vipModel->id;
                $reportVipModel->date_register = ''.time();
                $reportVipModel->save();
            }
            return $this->render('editvip',[
                'vipModel' => $vipModel,
                'type' => 'update',
            ]);
        }
    }
    
    public function actionRemovevip($id)
    {
        $vipModel = new CardVip;
        if(isset($id)){
            $vipModel = CardVip::find()->where(['id'=> $id])->one();
            $vipModel->delete();
            return $this->goBack();
        }
    }
    
    public function actionEditpersonnel($id)
    {
        if(isset($id)){
            $personnelModel = CardPersonnel::findOne($id);
            $numberCard = $personnelModel->card_number;
            if($personnelModel->load(Yii::$app->request->post())){
                if($personnelModel->card_number == $numberCard)
                {
                    $personnelModel->setScenario('edit');
                }
            }
            if($personnelModel->load(Yii::$app->request->post()) && $personnelModel->validate()){
                $personnelModel->save();
//                $reportPersonnelModel = new ReportPersonnel();
//                $reportPersonnelModel->personnel_id = $personnelModel->id;
//                $reportPersonnelModel->date_register = ''.time();
//                $reportPersonnelModel->save();
            }
            return $this->render('editpersonnel',[
                'personnelModel' => $personnelModel,
                'type' => 'edit',
            ]);
        }
    }
    
    public function actionUpdatepersonnel($id)
    {
        if(isset($id)){
            $personnelModel = CardPersonnel::findOne($id);
            $numberCard = $personnelModel->card_number;
            if($personnelModel->load(Yii::$app->request->post())){
                if($personnelModel->card_number == $numberCard)
                {
                    $personnelModel->setScenario('edit');
                }
            }
            if($personnelModel->load(Yii::$app->request->post()) && $personnelModel->validate()){
                $personnelModel->save();
                $reportPersonnelModel = new ReportPersonnel();
                $reportPersonnelModel->personnel_id = $personnelModel->id;
                $reportPersonnelModel->date_register = ''.time();
                $reportPersonnelModel->save();
            }
            return $this->render('editpersonnel',[
                'personnelModel' => $personnelModel,
                'type' => 'update',
            ]);
        }
    }
    
    public function actionRemovepersonnel($id)
    {
        $personnelModel = new CardPersonnel;
        if(isset($id)){
            $personnelModel = CardPersonnel::find()->where(['id'=> $id])->one();
            $personnelModel->delete();
            return $this->goBack();
        }
    }
}
