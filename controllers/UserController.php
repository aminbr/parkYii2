<?php
namespace app\controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\Controller;
use app\models\User;
use app\models\Level;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\CashRemoval;
/**
 * Description of UserController
 *
 * @author hesam
 */
class UserController extends Controller {
    //put your code here
    public $enableCsrfValidation = FALSE;
    public function behaviors() {
        
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['createuser', 'edituser', 'removeuser'],
                'rules' =>[
                    [
                        'actions' => ['createuser', 'edituser', 'removeuser'],
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
                            }
                        },
                    ]
                ]
            ]
        ];
    }
    
    public function actionCreateuser()
    {
        $levelModel = Level::find()->all();
        $levelArray = ArrayHelper::map($levelModel, 'id', 'name');
        $userModel = new User;
        if($userModel->load(\Yii::$app->request->post())&&$userModel->validate()){
            $userModel->save();
            $cashRemoval = new CashRemoval();
            $cashRemoval->user_id = $userModel->id;
            $cashRemoval->removal_amount = 0;
            $cashRemoval->removal_date = time()."";
            $cashRemoval->save();
            $userModel->clearValue();
        }
        return $this->render('insert',[
            'userModel' => $userModel ,
            'levelArray' => $levelArray ,
        ]);
    }
    
    public function actionEdituser($id)
    {
        $levelModel = Level::find()->all();
        $levelArray = ArrayHelper::map($levelModel, 'id', 'name');
        if(isset($id)){
            $userModel = User::findOne($id);
            if($userModel->load(Yii::$app->request->post()) && $userModel->validate()){
                $userModel->save();
            }
            return $this->render('edit',[
                'userModel' => $userModel,
                'levelArray' => $levelArray ,
            ]);
        }
    }
    
    public function actionRemoveuser($id)
    {
        $userModel = new User;
        if(isset($id)){
            $userModel = User::find()->where(['id'=> $id])->one();
            $userModel->isDeleted = 1;
            $userModel->save();
            return $this->goBack();
        }
    }
    
    
}

