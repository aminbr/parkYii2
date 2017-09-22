<?php
namespace app\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\Controller;
use app\models\User;
use app\models\EnterExit;
use app\models\Transaction;
use app\models\FinancialReport;
use Yii;
/**
 * Description of ReportController
 *
 * @author hesam
 */
class ReportController extends Controller{
    //put your code here
    public function behaviors() {
        
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['parking', 'detail', 'fund', 'listuser'],
                'rules' =>[
                    [
                        'actions' => ['parking', 'detail', 'fund', 'listuser'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function(){
                            $level = Yii::$app->user->identity->level;
                            if($level == 3){
                                return TRUE;
                            }else if($level == 2){
                                return TRUE;
                            }else if($level == 1){
                                return FALSE;
                            }
                        },
                    ]
                ]
            ]
        ];
    }
    
    public function actionParking()
    {
        $enterExitModelParking = new \app\models\EnterExitSearch();
        $dataProvider = $enterExitModelParking->parking(Yii::$app->request->queryParams);
        return $this->render('parking', [
            'dataProvider' => $dataProvider,
            'enterExitModelParking' => $enterExitModelParking,
        ]);
    }
    
    public function actionDetail()
    {
        $enterExitModelSearch = new \app\models\EnterExitSearch();
        $dataProvider = $enterExitModelSearch->search(Yii::$app->request->queryParams);
        return $this->render('detail', [
            'dataProvider' => $dataProvider,
            'enterExitModelSearch' => $enterExitModelSearch,
        ]);
    }
    
    public function actionFund()
    {
        $cashRemovalModelSearch = new \app\models\CashReportSearch();
        $dataProvider = $cashRemovalModelSearch->search(Yii::$app->request->queryParams);
        return $this->render('fund', [
            'dataProvider' => $dataProvider,
            'cashRemovalModelSearch' => $cashRemovalModelSearch,
        ]);
    }
    
    public function actionFundparking()
    {
        $financialReportModel = new FinancialReport();
        $dataProvider = $financialReportModel->search(Yii::$app->request->queryParams);
        return $this->render('fundparking', [
            'financialReportModel' => $dataProvider,
        ]);
    }
    
    public function actionListuser()
    {
        $userModelSearch = new \app\models\UserSearch();
        $dataProvider = $userModelSearch->search(Yii::$app->request->queryParams);
        return $this->render('listuser', [
            'dataProvider' => $dataProvider,
            'userModelSearch' => $userModelSearch,
        ]);
    }
    // 1505771723 now time
    public function actionTestreport()
    {
//        $time = Yii::$app->utility->jalali_to_gregorian_date(1396,6,28,'/'); // تبدیل شمسی به میلادی
//        die(var_dump($time));
//        
//        die(var_dump(strtotime('2017/09/19'))); // تبدیل میلادی به ثانیه
        $financialReportModel = new FinancialReport();
        if($financialReportModel->load(Yii::$app->request->post()) && $financialReportModel->validate()){
            $financialReportModel->search();
        }
        
        return $this->render('testreport', [
            'time' => $time,
            'financialReportModel' => $financialReportModel,
        ]);
    }
    
    public function actionEditprice($id) {
        $enterExitModel = EnterExit::find()->joinWith('transaction')->where([EnterExit::tableName(). '.id' => $id])->one();
        
        $transactionModel = \app\models\Transaction::findOne($enterExitModel->transaction_id);
        if($transactionModel->load(Yii::$app->request->post()) && $transactionModel->validate()){
            $transactionModel->save();
        }
        return $this->renderAjax('editprice', [
            'transactionModel' => $transactionModel
        ]);
    }
    
    public function actionExitcar($id)
    {
        $userModel = new EnterExit;
        if(isset($id)){
            $enterExitModel = EnterExit::find()->where(['id'=> $id])->one();
            $enterExitModel->exit_date = ''.time();
            $transactionModel = new Transaction();
            $transactionModel->enter_exit_id = $enterExitModel->id;
            $transactionModel->user_id = $enterExitModel->user_id;
            $transactionModel->price = 0;
            $transactionModel->created_at = time()."";
            $transactionModel->save();
            $enterExitModel->transaction_id = $transactionModel->id;
            $enterExitModel->save();
            return $this->goBack();
        }
    }
    
    public function actionListvip()
    {
        $vipModelSearch = new \app\models\CardVipSearch();
        $dataProvider = $vipModelSearch->search(Yii::$app->request->queryParams);
        return $this->render('listvip', [
            'dataProvider' => $dataProvider,
            'vipModelSearch' => $vipModelSearch,
        ]);
    }
    
    public function actionListpersonnel()
    {
        $personnelModelSearch = new \app\models\CardPersonnelSearch();
        $dataProvider = $personnelModelSearch->search(Yii::$app->request->queryParams);
        return $this->render('listpersonnel', [
            'dataProvider' => $dataProvider,
            'personnelModelSearch' => $personnelModelSearch,
        ]);
    }
}
