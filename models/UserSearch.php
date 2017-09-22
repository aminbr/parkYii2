<?php

namespace app\models;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $level
 * @property integer $status
 */
class UserSearch extends User
{
    public function rules() {
        return [
            [['nickname', 'username', 'level', 'status', 'email'], 'safe']
        ];
    }
    
    public function search($params) {
        $activeQuery = static::find()->where("level !=8")->andWhere("level !=6")->andWhere(['isDeleted' => 0]);
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
        $activeQuery->andFilterWhere(['LIKE', 'email', $this->email])
                ->andFilterWhere(['LIKE', 'username', $this->username])
                ->andFilterWhere(['LIKE', 'nickname', $this->nickname])
                ->andFilterWhere(['LIKE', 'status', $this->status])
                ->andFilterWhere(['LIKE', 'level', $this->level]);
        return $dataProvider;
    }
}
