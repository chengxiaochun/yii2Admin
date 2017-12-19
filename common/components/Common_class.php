<?php

/* 
 * 公用类
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use backend\models\Adminfuncsurl;
use backend\models\Adminusergroup;

class Common_class
{
    /**
     * 递归获得功能树
     * @param type $ugid  用户组id
     * @param type $all  为假则只取 $ugid下的功能，否则获取全部
     * @return type
     */
    public static function getfuncs($ugid=null, $all=false)
    {
        $data = array();
       if( $ugid )
       {
           $data = Adminfuncsurl::getfuncsbyugid($ugid, 0);
       }
       else if( $all )
       {
           $data = Adminfuncsurl::find()->where("fatherfuid=0 AND adminfuncsurl.isDelete=0")
                   ->orderBy("sort ASC,fuid ASC")
                   ->asArray()->all();
       }
       return self::eachTreeforfuncs($data, $ugid);  //递归获得树结构
    }
    
    /**
     * 获得导航功能菜单树数组数据
     * @param array $data
     * @param inter $ugid
     * @return array
     */
    public static function eachTreeforfuncs($data,$ugid=null)
    {
        if( !is_array($data) || empty($data) )
        {
            return array();
        }
        foreach ($data as $key => $value)
        {
            if( $ugid  )
            {
                $children = Adminfuncsurl::getfuncsbyugid($ugid, $value["fuid"]);; //根据用户组递归功能
            }
            else
            {
                $children = Adminfuncsurl::find()->where("fatherfuid='$value[fuid]' AND adminfuncsurl.isDelete=0")
                        ->orderBy("sort ASC,fuid ASC")
                        ->asArray()->all();//递归所有功能
            }

            if( !empty($children))
            {
                $children = self::eachTreeforfuncs($children, $ugid);  //递归获得子菜单
                $data[$key]['children'] = $children;
            }
        }
        return $data;
    }
    
    /**
     * 获得树形用户组组数据
     * @return array
     */
    public static function getUsegroup()
    {
        $data = Adminusergroup::find()->where("ugfatherid='0' AND isDelete='0'")->asArray()->all();//只获得导航树的根节点
        $data = self::eachTreeforug($data);  //由根节点递归获得所有节点

        return $data;
    }
    
    /**
     * 获得左侧导航菜单
     * @param array $data //导航树形数组数据
     */
    public static function getTreeMenu(array $data)
    {
        if( empty($data) )
        {
            echo "";
        }

        foreach( $data as $val )
        {
            $fuURL = empty($val["fuURL"])||(substr($val['fuURL'], 0, 1) == "#") ? "javascript:void(0);" : $val['fuURL'];
            if( isset($val['children']) && !empty($val['children']) )
            {
                $html = '<a href="'.$fuURL.'">'
                        . '<i class="'.$val['icon_class'].'"></i>'
                        . '<span >'.$val['funame'].'</span>'
                        . '<span class="pull-right-container">'
                        . '<i class="fa fa-angle-left pull-right"></i><span>'
                        . '</a>';
            }
            else
            {
                $html = '<a href="'.$fuURL.'"><i class="'.$val['icon_class'].'"></i><span>'.$val['funame'].'</span></a>';
            }

            //如果是父层
            if( $val['fatherfuid'] == 0 )
            {
                echo '<li class="treeview" data-url="'.$fuURL.'">'.$html;
                if( isset($val['children']) )
                {
                    echo '<ul class="treeview-menu">';
                    self::getTreeMenu($val['children']);
                    echo "</ul>";
                }

                echo "</li>";
            }
            //子层
            else
            {
                echo '<li data-url="'.$fuURL.'">' .$html;
                if( isset($val['children']) )
                {
                    echo '<ul class="treeview-menu">';
                    self::getTreeMenu($val['children']);
                    echo "</ul>";
                }
                echo '</li>';
            }
        }
    }
    
    /**
     * 获得树形用户组组数据
     * @return array
     */
    public static function getAdminusergroup()
    {
        $data = Adminusergroup::find()->where("ugfatherid='0' AND isDelete='0'")->asArray()->all();//只获得导航树的根节点
        $data = self::eachTreeforug($data);  //由根节点递归获得所有节点

        return $data;
    }
    
    /**
     * 整理数据以获得用户分组树结构
     * @param array $arr
     * @return array
     * */
    public static function eachTreeforug($arr)
    {
        if( !empty($arr))
        {
            foreach ($arr as $key => $value)
            {
                //$children = $model->getbyugfatherid($value['ugid']);
                $children = Adminusergroup::find()->where("ugfatherid='".$value["ugid"]."' AND isDelete=0")->asArray()->all();

                if( !empty($children))
                {
                    $children = self::eachTreeforug($children);
                    $arr[$key]['children'] = $children;
                }
            }
        } else {
            return array();
        }
        return $arr;
    }
    
    /**
    *获取用户组树列表
    * @param array $data
    *
    */
   public static function getTreeUsergroup(array $data)
   {
       if( empty($data) )
       {
           echo "";
       }
       foreach( $data as $val )
       {
           echo '<li><em></em><div class="view-item">';
           if( isset($val['children']) )
           {
               echo '<i class="fold fa fa-minus-square"></i>';

           }
           $html = '<div class="checkbox">'.
           '<label><span class="val">'.$val["typename"].'</span></label>'.
           '<input type="text" class="edit-txt"/>'.
           '</div>'.
           '<div class="handle-btns editdel">'.
           '<button class="btn btn-info edit-btn" type="button" title="修改"><i class="fa fa-pencil"></i></button> '.
           '<button class="btn btn-danger del-btn" type="button" data-ugid="'.$val["ugid"].'" data-ugfatherid="'.$val["ugfatherid"].'" onclick="deleteUg(this)" title="删除"><i class="fa fa-trash"></i></button>'.
           '</div>'.
           '<div class="handle-btns savecancel">'.
           '<button class="btn btn-danger save-btn" type="button" data-ugid="'.$val["ugid"].'" onclick="saveUg(this)" title="保存"><i class="fa fa-save"></i></button> '.
           '<button class="btn btn-danger cancel-btn" type="button"   title="取消"><i class="fa fa-reply"></i></button>'.
           '</div>'.
           '<span class="tips"></span>';
           echo $html.'</div>';
           if( isset($val['children']) )
           {
               echo "<ul>";
   //            foreach ($val['children'] as $children)
   //            {
   //                    echo '<li>' .$children['text'];
                    self::getTreeUsergroup($val['children']);             //递归输出子菜单
   //                    echo '</li>';
   //
   //           }
               echo "</ul>";

           }
           echo "</li>";
       }
       echo "";
   }
    
    /**
    *获取所有功能树列表(无编辑按钮组)
    * @param array $data
    *
    */
   public static function getTreeUsergroupWithoutBtns(array $data)
   {
       if( empty($data) )
        {
            echo "";
        }
        foreach( $data as $val )
        {
            echo '<li><em></em><div class="view-item">';
            if( isset($val['children']) )
            {
                echo '<i class="fa fa-minus-square"></i>';

            }
            $html = '<div class="checkbox" data-ugid="'.$val["ugid"].'" onclick="empower(this)">'.
                '<label><span class="val">'.$val["typename"].'</span></label>'.
                '<input type="text" class="edit-txt"/>'.
                '</div>';
            echo $html.'</div>';
            if( isset($val['children']) )
            {
                echo "<ul>";
                self::getTreeUsergroupWithoutBtns($val['children']);             //递归输出子菜单
                echo "</ul>";

            }
            echo "</li>";
    }
    echo "";
   }
   
   /**
    *获取所有功能树列表(无编辑按钮组)
    * @param array $data
    *
    */
   public static function getTreeFuncsWithoutBtns(array $data)
   {
       if( empty($data) )
       {
           echo "";
       }
       foreach( $data as $val )
       {
           echo '<li><em></em><div class="view-item">';
           if( isset($val['children']) )
           {
               echo '<i class="fa fa-minus-square"></i>';

           }
           $html = '<div class="checkbox">'.
               '<label><input type="checkbox" name="funcbox"  value="'.$val["fuid"].'"/><span class="val">'.$val["funame"].'</span></label>'.
               '<input type="text" class="edit-txt"/>'.
               '</div>';
           echo $html.'</div>';
           if( isset($val['children']) )
           {
               echo "<ul>";
               self::getTreeFuncsWithoutBtns($val['children']);             //递归输出子菜单
               echo "</ul>";

           }
           echo "</li>";
       }
       echo "";
   }
   
   /**
    *获取所有功能树列表
    * @param array $data
    *
    */
   public static function getTreeFuncsList($data)
   {
       if( empty($data) )
       {
           echo "";
           return;
       }
       foreach( $data as $val )
       {
           echo '<li><em></em><div class="view-item">';
           if( isset($val['children']) )
           {
               echo '<i class="fa fa-minus-square"></i>';
           }
           $html = '<div class="checkbox">'.
                    '<span class="val">'.$val["funame"].'</span>'.
                    '</div>'.
                    '<div class="handle-btns">'.
                    '<button data-toggle="modal" data-target="#updatefuncs_win" '
                   . 'data-fuid="'.$val["fuid"].'" '
                  // . 'data-fatherfuname="'.$val["fatherfuname"].'" '
                   . 'data-funame="'.$val["funame"].'" '
                   . 'data-fuurl="'.$val["fuURL"].'" '
                   . 'data-isShow="'.$val["isShow"].'" '
                   . 'data-isshow="'.$val["isShow"].'" '
                   . 'data-ischeck="'.$val["isCheck"].'" '
                   . 'data-sort="'.$val["sort"].'" '
                   . 'data-fatherfuid="'.$val["fatherfuid"].'" '
                   . 'class="btn btn-info edit-btn" type="button" title="点击修改">'
                   . '<i class="fa fa-pencil"></i></button> '.
                    '</div>';
           echo $html.'</div>';
           if( isset($val['children']) )
           {
               echo "<ul>";
               self::getTreeFuncsList($val['children']);             //递归输出子菜单
               echo "</ul>";
           }
           echo "</li>";
       }
       echo "";
   }



    /**
     * 发送验证短信
     * @param $telphone 手机号
     * @param $message  发送内容
     * @return mixed    发送返回状态
     */
    public static function sendMessage($telphone,$message)
    {
        $uid = 523410;
        $psw = md5("123456");
        $msgid = time().mt_rand(000000,999999);
        $msg = mb_convert_encoding($message,"GBK","UTF-8");
        $msg = urlencode($msg);
        $postUrl = "http://c.kf10000.com/sdk/SMS?cmd=send&uid=$uid&psw=$psw&mobiles=$telphone&msgid=$msgid&msg=$msg";

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);              //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                 //设置header不包含在输出中
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //要求结果为字符串且输出到屏幕上
        $data = curl_exec($ch);                                //运行curl
        curl_close($ch);
        return $data;
    }
    
    /**
     * 处理上传图片文件， 成功则返回相对路径
     * @param string $destination_folder    保存图片相对路径
     * @param type $savefilename            保存图片名
     * @param type $upfile              post名
     * @return string                   若保存成功返回相对地址
     */
    public static function updateimg($destination_folder='',$savefilename='',$upfile="upfile")
    {
        //上传文件类型列表
        $uptypes=array(
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/pjpeg',
            'image/gif',
            'image/bmp',
            'image/x-png'
        );
        $max_file_size=3000000;     //上传文件大小限制, 单位BYTE
         
        if(!file_exists($destination_folder))
        {
            if(!mkdir($destination_folder, 0777, true))
            {
                return "";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {  
            if (!is_uploaded_file($_FILES[$upfile]["tmp_name"]))
            //是否存在文件
            {
                return "";
            }
    
            $file = $_FILES[$upfile];
            if($max_file_size < $file["size"])
            //检查文件大小
            {
                return "";
            }
             
            if(!in_array($file["type"], $uptypes))
            //检查文件类型
            {
                return "";
            }
            
            $filename=$file["tmp_name"];
            $pinfo=pathinfo($file["name"]);
            $ftype=$pinfo['extension'];
            $savefilename = empty($savefilename)?rand(0,1000).  time():$savefilename;
            $destination_folder = trim($destination_folder,"/")."/";  //确保路径结尾加上/
            $destination = $destination_folder.$savefilename.".".$ftype;
       
            if(!move_uploaded_file ($filename, $destination))
            {
                return "";
            }
            return $destination;
        }
        return "";
    } 
    
    /**
     * 处理上传文件， 成功则返回相对路径
     * @param string $destination_folder    保存文件相对路径
     * @param type $savefilename            保存文件名
     * @param type $upfile              post名
     * @return string                   若保存成功返回相对地址
     */
    public static function updatefile($destination_folder='',$savefilename='',$upfile="upfile")
    {
        if(!file_exists($destination_folder))
        {
            if(!mkdir($destination_folder, 0777, true))
            {
                return "";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {  
            if (!is_uploaded_file($_FILES[$upfile]["tmp_name"]))
            //是否存在文件
            {
                return "";
            }
    
            $file = $_FILES[$upfile];
            //var_dump($file);
            $filename=$file["tmp_name"];
            $pinfo=pathinfo($file["name"]);
            $ftype=$pinfo['extension'];
            $savefilename = empty($savefilename)?rand(0,1000).  time():$savefilename;
            $destination_folder = trim($destination_folder,"/")."/";  //确保路径结尾加上/
            $destination = $destination_folder.$file["name"];//.".".$ftype;
       
            if(!move_uploaded_file ($filename, $destination))
            {
                return "";
            }
            return $destination;
        }
        return "";
    } 
    
    /**
     * 获取替换后的ResquesUri 
     * @param type $k QUERY_STRING 中的k 
     * @param type $replace  k要替换的新内容
     * @param type $flag  标志
     * @return type 例如 当flag为flase时ResquesUri=/index/index?r=kdjfk&md=1&cd=2 若$k=r,$replace=qwer 最后返回/index/index?r=qwer&md=1&cd=2, flag为真则返回/index/index?r=qwer
     */
    public static function getResquesUri($k,$replace,$flag=0)
    {
        $pattern = "![?|&]*$k=[^&]*!";
        $requestQuery = $_SERVER["QUERY_STRING"];
        $requestUri = $_SERVER["REQUEST_URI"];
        $route = str_replace($requestQuery, "", $requestUri);  //获得请求路由
        $requestQuery = preg_replace("![?|&]*v=[^&]*!", "", $requestQuery);
        
        if( empty(preg_match($pattern, $requestQuery) || empty($k)) || $k == "" )
        {
            $ret = $flag?$route:$route.$requestQuery;
            return $ret."&v=".time();
        }
        
        $QUERY_STRING = trim(preg_replace($pattern, "", $requestQuery));
        $QUERY_STRING = trim($QUERY_STRING,"?");
        $QUERY_STRING = trim($QUERY_STRING,"&");
        $ret = $flag?$route."$k=$replace":$route.$k."=".$replace."&".$QUERY_STRING;
        
        return $ret."&v=".time();
    }
    
    /** 
     * 生成 随机浮点数
     * @param type $min
     * @param type $max
     * @return type
     */
    public static function randomFloat($min = 0, $max = 1)  
    {   
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);  
    } 
    
    /**
     * 字符加密
     * @param type $data  要加密数据
     * @param type $key   加密key
     * @return type
     */
    public static function encrypt($data, $key="dfaueoijfdkfdfkjd")  
    {  
        $key    =   md5($key);  
        $x      =   0;  
        $len    =   strlen($data);  
        $l      =   strlen($key);  
        for ($i = 0; $i < $len; $i++)  
        {  
            if ($x == $l)   
            {  
                $x = 0;  
            }  
            $char .= $key{$x};  
            $x++;  
        }  
        for ($i = 0; $i < $len; $i++)  
        {  
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);  
        }  
        return base64_encode(gzcompress($str));  
    }  
    
    /**
     * 字符解密
     * @param type $data  加密过的数据
     * @param type $key   解密key
     * @return type
     */
    public static function decrypt($data, $key="dfaueoijfdkfdfkjd")  
    {  
        $key = md5($key);  
        $x = 0;  
        $data = gzuncompress(base64_decode($data));  
        $len = strlen($data);  
        $l = strlen($key);  
        for ($i = 0; $i < $len; $i++)  
        {  
            if ($x == $l)   
            {  
                $x = 0;  
            }  
            $char .= substr($key, $x, 1);  
            $x++;  
        }  
        for ($i = 0; $i < $len; $i++)  
        {  
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))  
            {  
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));  
            }  
            else  
            {  
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));  
            }  
        }  
        return $str;  
    } 
    
    /**
     * 判断是否是手机号
     * @param type $mobile
     * @return boolean
     */
    public static function isMobile($mobile)
    {
        if(preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
            return TRUE;
        }else{  
            FALSE;
        } 
    }
    
    /**
     * 判断是否是邮箱
     * @param type $mobile
     * @return boolean
     */
    public static function isEmail($email)
    {
        if(preg_match("/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/",$email)){  
            return TRUE;
        }else{  
            FALSE;
        } 
    }
}

