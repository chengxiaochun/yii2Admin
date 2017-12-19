<?php

namespace backend\models;

use Yii;

class Adminusergroup extends \common\models\Adminusergroup
{
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
        $data = array_merge(self::getcols(),$data);
        
        $model = __CLASS__;
        $self = new $model;
        self::setColVal($self, $data);
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
            $cols = self::tableName().".*";
        }
        
        $select = self::find()->select($cols)
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
    
    /**
     * 判断是否可以删除用户组 如果该用户组下存在用户则不能删除
     * @param type $ugid 用户组id
     * @return boolean 可以删除返回true 否则返回false
     */
    public static function iscandel($ugid)
    {
        $user = \backend\models\Adminuser::find()->where(["ugid"=>$ugid])->asArray()->all();
        if( !empty($user) )
        {
            return FALSE;
        }
        $child = self::find()->select("ugid")->where(["ugfatherid"=>$ugid,"isDelete"=>0])->asArray()->all();
        if( empty($child) )
        {
            return TRUE;
        }
        foreach ($child as $val)
        {
            if( !self::iscandel($val["ugid"]) )
            {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    /**
     * 删除后台用户组 
     * @param type $ugid 用户组id
     * @return string 如果用户组及其子组下存在用户返回 used 不存在并删除成功返回 ok 否则返回 error
     */
    public static function del($ugid)
    {
        if( !self::iscandel($ugid) )
        {
            return "used";
        }
        
        $child = self::find()->select("ugid")->where(["ugfatherid"=>$ugid,"isDelete"=>0])->asArray()->all();
        $ug = self::findOne($ugid);
        $ug->isDelete = 1;
        if( !empty($child) )
        {
            foreach ( $child as $val )
            {
                if( self::del($val["ugid"]) == "error" )
                {
                    return "error";
                }
            } 
        }
        if( $ug->save() )
        {
           return "ok";
        }
        else
        {
            return "error";
        }    
    }
}
