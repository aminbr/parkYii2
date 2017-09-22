<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "camera".
 *
 * @property integer $id
 * @property string $url_enter
 * @property string $url_exit
 * @property string $url_capture
 */
class Camera extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'camera';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_enter', 'url_exit', 'url_capture'], 'required'],
            [['url_enter', 'url_exit', 'url_capture'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_enter' => 'آدرس دوربین ورودی(MJPG)',
            'url_exit' => 'آدرس دوربین خروجی(MJPG)',
            'url_capture' => 'آدرس عکس دوربین ورودی  (JPG)',
        ];
    }
}
