<?php

namespace backend\models;

use Yii;

class Adminfuncsurl extends \common\models\Adminfuncsurl
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
     * 由用户组ID和功能父ID获得功能
     * @param inter $ugid 用户组ID
     * @param inter $fuid 功能ID
     * @return array
     */
    public static function getfuncsbyugid($ugid,$fuid)
    {
        $data = self::find()->innerJoin("adminaccess","adminfuncsurl.fuid=adminaccess.fuid")
                ->innerJoin("adminusergroup","adminusergroup.ugid=adminaccess.ugid")
                ->where("adminusergroup.ugid=$ugid AND fatherfuid=$fuid AND adminfuncsurl.isShow=1 AND adminfuncsurl.isDelete=0")
                ->orderBy("sort ASC,fuid ASC")
                ->asArray()->all();
        return  $data;
    }
    
    /**
     * 添加
     * @param type $data
     */
    public static function add($data)
    {
        if( !is_array($data) || empty($data) )
        {
            return ["status"=>"error","message"=>"没有数据要添加！","color"=>"red"];
        }
        $data = array_merge(self::getcols(),$data);
        
        if( empty($data["funame"]) )
        {
            return ["status"=>"error","message"=>"功能名不能为空！","color"=>"red"];
        }
        if( $data["sort"] < 0 )
        {
            return ["status"=>"error","message"=>"排序数字要大于等于零！","color"=>"red"];
        }
        
        $self = new Adminfuncsurl();
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
}
