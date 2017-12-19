<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adminuser".
 *
 * @property string $adminuserid
 * @property string $username
 * @property string $access_token
 * @property integer $token_time
 * @property integer $allowance
 * @property integer $allowance_updated_at
 * @property string $photo
 * @property string $password_hash
 * @property string $mobilNo
 * @property string $ugid
 * @property string $userbasestate
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Adminuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['token_time', 'allowance', 'allowance_updated_at', 'ugid'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'access_token', 'photo', 'password_hash', 'mobilNo', 'userbasestate', 'auth_key', 'password_reset_token', 'status'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adminuserid' => 'Adminuserid',
            'username' => 'Username',
            'access_token' => 'Access Token',
            'token_time' => 'Token Time',
            'allowance' => 'Allowance',
            'allowance_updated_at' => 'Allowance Updated At',
            'photo' => 'Photo',
            'password_hash' => 'Password Hash',
            'mobilNo' => 'Mobil No',
            'ugid' => 'Ugid',
            'userbasestate' => 'Userbasestate',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
