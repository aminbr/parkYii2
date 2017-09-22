<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "cash_report".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $removal_amount
 * @property string $removal_date
 */
class CashReportSearch extends CashReport
{
    public $removal_time;
    
    public $nickname;
    
    public function rules() {
        return [
            [['id', 'removal_amount', 'removal_date', 'nickname', 'removal_time'], 'safe']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'nickname' => 'نام کاربر',
            'removal_time' => 'ساعت برداشت',
            'id' => 'ای دی',
            'user_id' => 'ای دی کاربر',
            'removal_amount' => 'مبلغ برداشتی',
            'removal_date' => 'تاریخ برداشت',
        ];
    }
    
    public function search($params) {
        $activeQuery = static::find()
                ->joinWith('user');
        
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
        
        $activeQuery->andFilterWhere(['LIKE', 'removal_amount', $this->removal_amount])
                    ->andFilterWhere(['LIKE', 'user.nickname', $this->nickname]);
        return $dataProvider;
    }
}
