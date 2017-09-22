<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class CardVipSearch extends CardVip
{
    
    public function rules()
    {
        return [
            [['card_number', 'name', 'nt_code', 'price', 'days', 'plate_car', 'model_car'], 'safe'],
        ];
    }

    public function search($params) {
        $activeQuery = static::find()->where(['is_deleted' => 0]);
        
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
        
        $activeQuery->andFilterWhere(['LIKE', 'name', $this->name])
                    ->andFilterWhere(['LIKE', 'nt_code', $this->nt_code])
                    ->andFilterWhere(['LIKE', 'days', $this->days])
                    ->andFilterWhere(['LIKE', 'plate_car', $this->plate_car])
                    ->andFilterWhere(['LIKE', 'model_car', $this->model_car]);
        return $dataProvider;
    }
}
