<?php

namespace backend\models;

use Yii;

class Adminaccess extends \common\models\Adminaccess
{
    /**
    * 为一用户组授权，成功返回true,失败返回false
    * @param integer $ugid      用户组id
    * @param array   $arr_fuid  授权功能的id组
    * @return boolean
    */
   public static function ugauthorize($ugid = null, $arr_fuid = null)
   {
       if( $ugid == null || !ctype_digit($ugid) )
       {
           return false;
       }
       $db = self::getDb();
       $Transaction = $db->beginTransaction();

       try
       {
           self::deleteAll(["ugid"=>$ugid]);    //先将该组对应授权都删掉   
           if( !empty($arr_fuid) )                      //重新插入新值
           {
               $insert = "";
               foreach ($arr_fuid as $key => $value)
               {
                   $insert .= "($ugid,$value),";       
               }
               $insert = rtrim($insert, ",");
               $sql = "INSERT INTO ". self::tableName()."(ugid,fuid) VALUES".$insert;
               $db->createCommand($sql)->query();
           }
           
           $Transaction->commit();
       }
       catch (Exception $e)
       {
           ROLLBACK:
           $Transaction->rollBack();
           return false;
       }
       return true;
   }
}
