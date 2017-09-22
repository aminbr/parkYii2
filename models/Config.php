<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $mode
 * @property string $key_config
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key_config', 'value'], 'required'],
            [['mode', 'key_config', 'value'], 'string', 'max' => 50],
            ['value', 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode' => 'Mode',
            'key_config' => 'Key Config',
            'value' => Yii::t('app', 'Value'),
        ];
    }
    
    
    public function saveConfig($data)
    {
        foreach ($data as $key => $value){
//            $require = new \yii\validators\RequiredValidator();
//            $res = $require->validate($value);
//            if(!$res)
//            {
//                $this->addError('value', 'error');
//            }
            $this->key_config = $key;
            $this->value = $value;
            if(!$this->validate())
            {
                return false;
            }
                Yii::$app->db->createCommand("UPDATE config set value='".$value."' where key_config='".$key."'")->execute();
        }
    }
}
