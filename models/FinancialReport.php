<?php
namespace app\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Yii;
use yii\data\ActiveDataProvider;
/**
 * Description of CardReader
 *
 * @author Amin
 */
class FinancialReport extends \yii\base\Model{
    public $fromDate;
    public $tillDateOf;

    public function rules() {
        return [
            [['fromDate', 'typeInput', 'price', 'user_id'], 'safe'],
            [['fromDate', 'tillDateOf'], 'string'],
            [['fromDate', 'tillDateOf'], 'required'],
//            ['tagInput', 'cardValidate'],
        ];
    }
    // 31536000
    public function cardValidate($attribute)
    {
        
    }
    
    public function search($params) {
        // چک کردن مقدار ورود
        $fromDate = $this->fromDate;
        $tillDateOf = $this->tillDateOf;
        if(empty($fromDate)){
            $fromDate = '1396/6/5';
        }
        if(empty($tillDateOf)){
            $tillDateOf = '1396/6/5';
        }
//        die(var_dump($tillDateOf));
//        if(isset($fromDate)&& isset($tillDateOf))
//        {
            // از تاریخ
            $buffer1 = explode('/', $fromDate);
            $yearFromDate = $buffer1[0];
            $monthFromDate = $buffer1[1];
            $dayFromDate = $buffer1[2];
    //        die(var_dump($year0.'-'.$month0.'-'.$day0));
            $date_j_to_g_fromDate = Yii::$app->utility->jalali_to_gregorian_date($yearFromDate,$monthFromDate,$dayFromDate); // تبدیل شمسی به میلادی
            $secondFromDate = strtotime($date_j_to_g_fromDate[0].'/'.$date_j_to_g_fromDate[1].'/'.$date_j_to_g_fromDate[2]); // تبدیل میلادی به ثانیه
    //        die(var_dump($secondFromDate));

            // تا تاریخ
            $buffer2 = explode('/', $tillDateOf);
            $yearTillDateOf = $buffer2[0];
            $monthTillDateOf = $buffer2[1];
            $dayTillDateOf = $buffer2[2];
            $date_j_to_g_tillDateOf = Yii::$app->utility->jalali_to_gregorian_date($yearTillDateOf,$monthTillDateOf,$dayTillDateOf); // تبدیل شمسی به میلادی
            $secondTillDateOf = strtotime($date_j_to_g_tillDateOf[0].'/'.$date_j_to_g_tillDateOf[1].'/'.$date_j_to_g_tillDateOf[2]); // تبدیل میلادی به ثانیه
    //        die(var_dump($secondTillDateOf));
            $activeQuery = Transaction::find()
                    ->where(['>=', 'created_at', $secondFromDate])
                    ->andWhere(['<=', 'created_at', $secondTillDateOf])
                    ->all();
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
            return $dataProvider;
//        }
//        else 
//        {
//            $this->fromDate = '1396/6/5';
//            $this->tillDateOf = '1396/6/5';
//            
//        }
        
//        if(isset($transactionModel))
//        {
//            return $transactionModel;
//        }
//        else
//        {
//            return FALSE;
//        }
//        die(var_dump(count($transactionModel)));
        
    }
    
    public function attributeLabels()
    {
        return [
            'fromDate' => 'از تاریخ',
            'tillDateOf' => 'تا تاریخ',
        ];
    }
}
