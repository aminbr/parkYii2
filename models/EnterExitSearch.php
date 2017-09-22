<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "enter_exit".
 *
 * @property integer $id
 * @property integer $card_id
 * @property string $enter_date
 * @property string $enter_time
 * @property string $enter_photo
 * @property integer $user_id
 * @property string $exit_date
 * @property string $exit_time
 * @property integer $transaction_id
 */
class EnterExitSearch extends EnterExit
{
    public $nickname;
    public $type;



    public function rules() {
        return [
            [['id','nickname', 'type', 'card_id', 'enter_date', 'enter_time', 'exit_date', 'exit_time', 'enter_photo',], 'safe']
        ];
    }
    
    
    
    
    public function search($params) {
        $activeQuery = static::find()->where("exit_date !=''")
                ->joinWith('user')
                ->joinWith('card');
        $dataProvider = new ActiveDataProvider([
            'query' => $activeQuery,
            'pagination' => [
                'totalCount' => $activeQuery->count(),
                'pageSize' => 10,
            ]
        ]);
        if(!$this->load($params) && $this->validate())
        {
            return $dataProvider;
        }
        
        // چک کردن مقدار ورود
        $date_enter = $this->enter_date;
        $second_date_enter = $this->enter_date;
        if(!empty($date_enter))
        {
//                    die(var_dump($date_enter));
            $buffer1 = explode('/', $date_enter);
            $year0 = $buffer1[0];
            $month0 = $buffer1[1];
            $day0 = $buffer1[2];
//            die(var_dump($year0.'-'.$month0.'-'.$day0));

            $date_j_to_g = Yii::$app->utility->jalali_to_gregorian_date($year0,$month0,$day0); // تبدیل شمسی به میلادی
//            die(var_dump($date_j_to_g));
            $second_date_enter = strtotime($date_j_to_g[0].'/'.$date_j_to_g[1].'/'.$date_j_to_g[2]); // تبدیل میلادی به ثانیه
//            die(var_dump($second_date));
        }
        $date_exit = $this->exit_date;
        $second_date_exit = $this->exit_date;
        // چک کردن مقدار خروج
        if(!empty($date_exit))
        {
//            die(var_dump($date_exit));
            $buffer1 = explode('/', $date_exit);
            $year0 = $buffer1[0];
            $month0 = $buffer1[1];
            $day0 = $buffer1[2];
//            die(var_dump($year0.'-'.$month0.'-'.$day0));

            $date_j_to_g = Yii::$app->utility->jalali_to_gregorian_date($year0,$month0,$day0); // تبدیل شمسی به میلادی
//            die(var_dump($date_j_to_g));
            $second_date_exit = strtotime($date_j_to_g[0].'/'.$date_j_to_g[1].'/'.$date_j_to_g[2]); // تبدیل میلادی به ثانیه
//            die(var_dump($second_date));
        }
        
        
        $activeQuery->andFilterWhere(['LIKE', 'nickname', $this->nickname])
                ->andFilterWhere(['LIKE', 'type', $this->type])
                ->andFilterWhere(['>=', 'enter_date', $second_date_enter])
                ->andFilterWhere(['<=', 'exit_date', $second_date_exit]);
        return $dataProvider;
    } 
    
    
    public function attributeLabels()
    {
        return [
            'id' => 'ای دی',
            'card_id' => 'شماره کارت',
            'enter_date' => 'تاریخ ورود',
            'enter_time' => 'ساعت ورود',
            'enter_photo' => 'تصویر خودرو',
            'user_id' => 'ای دی کاربر',
            'exit_date' => 'تاریخ خروج',
            'exit_time' => 'ساعت خروج',
            'transaction_id' => 'Transaction',
            'nickname' => 'نام کاربر',
            'type' => 'نوع کارت',
        ];
    }
    
    
    
    
    
    public function parking($params) {
        $activeQuery = static::find()->where(['exit_date' => '',]);
        $dataProvider = new ActiveDataProvider([
            'query' => $activeQuery,
        ]);
        
        if(!$this->load($params) && $this->validate()){
            return $dataProvider;
        }
    }
}
