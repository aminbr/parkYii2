<?php

namespace app\models;

use Yii;

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
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nickname', 'username', 'password', 'level'], 'required', 'message' => 'فیلد "{attribute}" نباید خالی باشد'],
            [['level', 'status'], 'integer'],
            [['nickname', 'username', 'password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['username'], 'unique', 'message' => 'این نام قبلا در سیستم ثبت شده است'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'نام',
            'username' => 'نام کاربری',
            'password' => 'رمز ورود',
            'email' => 'ایمیل',
            'level' => 'سطح دسترسی',
            'status' => 'وضعیت',
        ];
    }
    
    public function clearValue()
    {
        $this->nickname = "";
        $this->username = "";
        $this->email = "";
        $this->password= "";
        $this->level = "";
    }
    
    public static function findByUsername($username) {
        return static::find()->where(['username' => $username])->one();
    }
    
    public function validatePassword($password)
    {
        return $this->password == $password;
    }

    public function getAuthKey() {
        return static::findOne($this->id);
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return TRUE;
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }

}
