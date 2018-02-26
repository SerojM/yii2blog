<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $isAdmin
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['username', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
        ];
    }


    public static function findIdentity($id)
    {
        return Users::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
    public static function findByEmail($email){
        return Users::find()->where(['email'=>$email])->one();
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }


}
