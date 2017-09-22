<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report_personnel".
 *
 * @property integer $id
 * @property integer $personnel_id
 * @property string $date_register
 */
class ReportPersonnel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_personnel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personnel_id', 'date_register'], 'required'],
            [['personnel_id'], 'integer'],
            [['date_register'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'personnel_id' => 'Personnel ID',
            'date_register' => 'Date Register',
        ];
    }
}
