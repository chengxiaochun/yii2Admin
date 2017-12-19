<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;


class Adminuser extends \common\models\Adminuser implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['adminuserid' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * 获取表字段
     * @return array  格式 key(字段名)=>value(默认值)
     */
    public static function getcols()
    {
        $data = self::getTableSchema()->columns;
        foreach ($data as $k=>$v)
        {
            $data[$k] = $v->defaultValue;
        }
        return $data;
    }
    
    /**
     * 设置字段值
     * @param Adminfuncsurl $self
     * @param type $data
     */
    public static function setColVal($self,$data)
    {
        foreach ($data as $k=>$val)
        {
            if( $self->hasAttribute($k) )
            {
                $self->setAttribute($k, $val);
            }
        }
    }
    
    /**
     * 添加
     * @param array $data 
     */
    public static function add($data=[])
    {
        if( !is_array($data) || empty($data) )
        {
            return ["status"=>"error","message"=>"没有数据要添加！","color"=>"red"];
        }
        if( !isset($data["passwd"]) || strlen($data["passwd"]) < 4 )
        {
            return ["status"=>"error","message"=>"密码位数必须大于等于4位！","color"=>"red"];
        }
        if( !isset($data["ugid"]) || !ctype_digit($data["ugid"]) )
        {
            return ["status"=>"error","message"=>"请选择用户分组！","color"=>"red"];
        }
        if( isset($data["mobilNo"]) && !empty($data["mobilNo"]) )
        {
            if( !\common\components\Common_class::isMobile($data["mobilNo"]) )
            {
                return ["status"=>"error","message"=>"手机号格式不对！","color"=>"red"];
            }
            if( self::findOne(["mobileNo"=>$data["mobilNo"]]) )
            {
                return ["status"=>"error","message"=>"该手机号已经存在！","color"=>"red"];
            }
        }
        if( self::findByUsername($data["username"]) )
        {
            return ["status"=>"error","message"=>"用户已经存在！","color"=>"red"];
        }
        $data["created_at"] = $data["updated_at"] = date("Y-m-d H:i:s");
        $data = array_merge(self::getcols(),$data);
        
        $model = __CLASS__;
        $self = new $model;
        self::setColVal($self, $data);
        $self->setPassword($data["passwd"]);
        
        if( $self->save() && empty($self->getErrors()))
        {
            return ["status"=>"ok","message"=>"添加成功！","color"=>"green"];
        }
        return ["status"=>"error","message"=>"添加失败！ for ".  json_encode($self->getErrors()),"color"=>"red"];
    }
    
    /**
     * 修改
     * @param array $attribute key=>value
     * @param array/string $condition 条件
     */
    public static function modify($attribute,$condition=null)
    {
        if( empty($attribute) || empty($condition) )
        {
            return ["status"=>"error","message"=>"没有数据要修改","color"=>"red"];
        }
        if( isset($attribute["mobilNo"]) && !empty($attribute["mobilNo"]) )
        {
            if( !\common\components\Common_class::isMobile($attribute["mobilNo"]) )
            {
                return ["status"=>"error","message"=>"手机号格式不对！","color"=>"red"];
            }
            if( self::findOne(["mobileNo"=>$attribute["mobilNo"]]) )
            {
                return ["status"=>"error","message"=>"该手机号已经存在！","color"=>"red"];
            }
        }
        try {
             if( self::updateAll($attribute, $condition) >= 1 )
             {
                 return ["status"=>"ok","message"=>"修改成功！","color"=>"green"];
             }
             return ["status"=>"error","message"=>"未做修改！","color"=>"red"];
        } catch (Exception $exc) {
            return ["status"=>"error","message"=>"修改出错！".$exc->getTraceAsString(),"color"=>"red"];
        }
    }
    
    /**
     * 获取列表数据
     * @param string $cols  筛选获得的字段
     * @param type $cond    筛选条件
     * @param type $order   排序
     * @param type $group   分组 
     * @return \yii\db\ActiveQuery select
     */
    public static function getList($cols=null,$cond=1,$order=null,$group=null)
    {
        if( empty($cols) )
        {
            $cols = self::tableName().".adminuserid,username,mobilNo,typename,userbasestate,created_at";
        }
        
        $select = self::find()->select($cols)
                ->innerJoin("adminusergroup", "adminusergroup.ugid=".self::tableName().".ugid")
                ->where(self::tableName().".status!=0")
                ->andWhere($cond);
        if($order)
        {
            $select->orderBy($order);
        }
        if( $group )
        {
            $select->groupBy($group);
        }
        return $select;
    }
}
