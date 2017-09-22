<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting_sys".
 *
 * @property integer $id
 * @property string $ip
 * @property string $ip2
 */
class SettingSys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting_sys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'ip2'], 'required'],
            [['ip', 'ip2'], 'string', 'max' => 100],
            [['ip', 'ip2'], 'url']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'آی پی نمایشگر اول',
            'ip' => 'آی پی نمایشگر دوم',
        ];
    }
    
    public function clearValue() {
        $this->ip = '';
    }
}
