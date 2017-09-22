<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property integer $id
 * @property string $vip_id
 * @property integer $date_register
 */
class ReportVip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_vip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vip_id', 'date_register'], 'required'],
            [['vip_id'], 'integer'],
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
            'vip_id' => 'ای دی کارت ویژه',
            'date_register' => 'تاریخ ثبت',
        ];
    }
}
