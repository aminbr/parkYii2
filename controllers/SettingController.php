<?php
namespace app\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\Controller;
use app\models\Setting;
use app\models\CashRemoval;
use app\models\CashReport;
use app\models\SettingSys;
use app\models\Camera;
use app\models\FindCard;
use Yii;
/**
 * Description of SettingController
 *
 * @author hesam
 */
class SettingController extends Controller{
    //put your code here
    public function behaviors() {
        
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['config', 'basicsetting', 'ipsetting'],
                'rules' =>[
                    [
                        'actions' => ['config', 'basicsetting', 'ipsetting'],
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
                            }else if($level == 6){
                                return TRUE;
                            }
                        },
                    ]
                ]
            ]
        ];
    }
    
    public function actionConfig() {
        
        $setting = Yii::$app->utility->getSetting();
        
        echo $setting['parking']['input_price'];
//        var_dump($config);
    }
    
    public function actionBasicsetting() {
        $configModel = new \app\models\Config();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post('Config');
            $configModel->saveConfig($data);
        }
        $setting = Yii::$app->utility->getSetting();
        return $this->render('basicsetting', [
            'setting' => $setting,
            'configModel' => $configModel
        ]);
    }
    public function actionCashremoval() {
        $query = new \yii\db\Query;
        $query  ->select(['Sum(transaction.Price) As totalPrice,'
            . ' (Sum(cash_removal.removal_amount))/count(transaction.user_id) AS checkout,'
            . ' Sum(transaction.Price) - (Sum(cash_removal.removal_amount))/count(transaction.user_id) As balancedPrice,'
            . ' user.nickname As nickname,'
            . ' user.Level,'
            . ' user.id']) 
                ->from('user')
                ->innerJoin('cash_removal', 'cash_removal.user_id = user.id')
                ->innerJoin('transaction', 'user.Id = transaction.user_id')
                ->groupBy('user.id')
                ->having('user.level= 1')
                ->all();
        $command = $query->createCommand();
        $data = $command->queryAll(); 
//        die(var_dump($data));
        
        return $this->render('cashremoval', [
            'data' => $data,
        ]);
    }
    
    public function actionRemovecash($userId, $balancedPrice) {
        $cashModel = CashRemoval::find()->where(['user_id' => $userId])
                ->one();
        $cashModel->removal_amount = intval($balancedPrice)+ $cashModel->removal_amount;
        $cashModel->removal_date = time()."";
        $result = $cashModel->update();
        if($result && $balancedPrice !=0)
        {
            $cashReportModel = new CashReport();
            $cashReportModel->user_id = $userId;
            $cashReportModel->removal_amount = intval($balancedPrice);
            $cashReportModel->removal_date = time()."";
            $cashReportModel->save();
            return $this->goBack();
        }  else {
            return $this->goBack();
        }
    }
    
    public function actionIpsetting() {
        $settingSysModel = SettingSys::find()->one();
        if($settingSysModel->load(Yii::$app->request->post()) && $settingSysModel->validate())
        {
            $settingSysModel->save();
        }
        return $this->render('ipsetting', [
            'settingSysModel' => $settingSysModel,
        ]);
    }
    
    public function actionCamerasetting() {
        $cameraModel = Camera::find()->one();
        if($cameraModel->load(Yii::$app->request->post()) && $cameraModel->validate())
        {
            $cameraModel->save();
        }
        return $this->render('camerasetting', [
            'cameraModel' => $cameraModel,
        ]);
    }
    
    public function actionFindcard() {
        $cardModel = new FindCard();
        $cardType = '';
        if($cardModel->load(\Yii::$app->request->post()) && $cardModel->validate())
        {
            $result = $cardModel->save();
            $cardType = $result['cardType'];
        }
        return $this->render('findcard', [
            'cardModel' => $cardModel,
            'cardType' => $cardType,
        ]);
    }
}

