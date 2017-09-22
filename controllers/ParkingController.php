<?php
namespace app\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\Controller;
use Yii;
use app\models\CardReader;
use app\models\Transaction;
use app\models\EnterExit;
use yii\web\Response;
use app\models\LoginForm;
use app\models\CashRemoval;
use app\models\SettingSys;
/**
 * Description of ParkingController
 *
 * @author hesam
 */
class ParkingController extends Controller
{
    
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['login','consol', 'parkingcapacity'],
                'rules' =>[
                    [
                        'actions' => ['login', 'about'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['consol', 'parkingcapacity',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function(){
                            $level = Yii::$app->user->identity->level;
                            if($level == 3){
                                return TRUE;
                            }else if($level == 2){
                                return \Yii::$app->controller->redirect(['report/parking']);
                            }else if($level == 1){
                                return TRUE;
                            }else if($level == 8){
                                return \Yii::$app->controller->redirect(['card/createcard']);
                            }else if($level == 6){
                                return \Yii::$app->controller->redirect(['setting/ipsetting']);
                            }
                        },
                    ]
                ]
            ]
        ];
    }
    public $defaultAction='consol';
    
    //put your code here
    public function actionConsol()
    {
        
        $price = null;
        $park_time = null;
        $cash = null;
        $capacityParking = null;
        $validateDay = null;
        $typeCard = null;
        $plateVip = null;
        
        $cardReaderModel = new CardReader();
        if($cardReaderModel->load(Yii::$app->request->post()) && $cardReaderModel->validate())
        {
            if($cardReaderModel->typeInput == 'enter'){
                $result = $cardReaderModel->enter_car();
                if($result == TRUE){
                    Yii::$app->session->setFlash("success", '100000');
                }
            }
            
            
            else if($cardReaderModel->typeInput == 'exit')
            {
                $result = $cardReaderModel->exit_car();
                $price = $result['price'];
                $typeCard = $result['type'];
                $validateDay = $result['days'];
                $plateVip = $result['plateVip'];
                Yii::$app->session->setFlash("success", '100000');
                $park_time = $result['park_time'];
                // موجودی صندوق
                $cash = Transaction::find()->sum('price');
                
                
            }
        }
        return $this->render('consol', [
            'cardReaderModel' => $cardReaderModel,
            'price' => $price,
            'parkTime' => $park_time,
            'cash' => $cash,
            'capacity' => $capacityParking,
            'validateDay' => $validateDay,
            'typeCard' => $typeCard,
            'plateVip' => $plateVip,
        ]) ;
    }
    public function actionOpengateenter() {
        $configModel = SettingSys::find()->one();
        $addressDisplay = $configModel->ip;
        $ch = curl_init($addressDisplay."/2n");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_exec($ch);
        curl_close($ch);
        return TRUE;
    }
      
    public function actionParkingcapacity() 
    {   
        Yii::$app->response->format = Response::FORMAT_JSON;
        // ظرفیت پارکینگ
        $setting = Yii::$app->utility->getSetting();
        $capacity = $setting['parking']['capacity'];
        $countCarEnter = EnterExit::find()->Where(['exit_date' => '',])
            ->andwhere("enter_date != '' ")->count();
        $capacityParking = $capacity - $countCarEnter;
        // موجودی صندوق
        $cashTransaction = Transaction::find()->where(['user_id' => Yii::$app->user->identity->id ])->sum('price');
        $cashRemoval = CashRemoval::find()->where(['user_id' => \Yii::$app->user->identity->id ])->sum('removal_amount');
        $cash = $cashTransaction - $cashRemoval;
        $level = Yii::$app->user->identity->level;
        $totalAmount = Transaction::find()->sum('price');
        return [
                'capacity' => $capacityParking,
                'fund' => $cash,
                'totalAmount' => $totalAmount,
                'level' => $level,
            ];
    }
    
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionLogin()
    {
//        public $enableCsrfValidation = FALSE;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        try {
            Yii::$app->user->logout();
        } catch (Exception $ex) {
            session_unset();
        }
        return $this->goHome();
    }
    
    public function actionImageUrl($tagnum) {
        header("Content-Type:image/png");
        $enterExitModel = EnterExit::find()->where(['card_id' => $tagnum])->orderBy('id desc')->one();
        
        if(!isset($enterExitModel)){
            throw new \yii\web\HttpException("error", 501);
        }
        if($enterExitModel->enter_photo == 'default.jpeg'){
            return readfile(Yii::$app->basePath.'/web/upload/default.jpeg');
        }  else {
            return readfile(Yii::$app->basePath.'/web/upload/'.$enterExitModel->enter_photo.'.jpeg');
        }
    }
}
