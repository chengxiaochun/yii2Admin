<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\controllers\BaseController;
use backend\models\Adminuser;
use backend\models\Adminusergroup;

/**
 * Base controller
 */
class AdminController extends BaseController
{
    /**
     * 管理员列表
     */
    public function actionAdminlist()
    {
        if( $this->getParam("data") == "getdata" )
        {
            Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
            $draw   = Yii::$app->request->post("draw");         //前端向服务器请求的次数
            $start  =  Yii::$app->request->post('start');       //从多少开始
            $length = Yii::$app->request->post('length');       //每页显示多少条
            $cond = $this->getCond();
            $select = Adminuser::getList("", $cond,"adminuserid DESC");
            $count = $select->count();
            $res = $select->offset($start)->limit($length?$length:10)->asArray()->all();
            
            return ["draw"=>$draw,"recordsFiltered"=>$count,"data"=>$res];
        }
        $ugfather = Adminusergroup::getList("", ["isDelete"=>0,"ugfatherid"=>0])->asArray()->all();
        return $this->render("adminlist",["ugfather"=>$ugfather]);
    }
    
    /**
     * 用户分组多级联动
     */
    public function actionAdmingroup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $ugid = $this->getParam('ugid');
        if( $ugid==0 || $ugid=='0' ){
            return ["status"=>"error"];
        }
        
        if( empty($ugArr = Adminusergroup::getList(null,["ugfatherid"=>$ugid, "isDelete"=>0])->asArray()->all()) ){
            return ["status"=>"error"];
        } else {
            return ["status"=>"ok", "ugdata" => $ugArr];
        }
    }
    
    /**
     * 添加管理员
     */
    public function actionAddadmin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        return Adminuser::add($this->getParam("data"));
    }
    
     /**
     * 编辑管理员
     */
    public function actionEditadmin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $attribute = $this->getParam("data");
        $cond = ["username"=>$attribute["username"]];
        unset($attribute["username"]);
        return Adminuser::modify($attribute,$cond);
    }
    
    /**
     * 修改密码
     */
    public function actionUpdatepw()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $username = $this->getParam("username");
        $passwd = $this->getParam("passwd");
        $repasswd = $this->getParam("repasswd");
        $user = Adminuser::findByUsername($username);
        if(!$user)
        {
            return ["status" => "error", "color" => "#ff0000", "message" => "找不到该用户" ];
        }
        if( strlen($passwd) < 4 ) 
        {
            return ["status" => "error", "color" => "#ff0000", "message" => "密码位数不能少于4位!" ];
        } 
        else if ($passwd != $repasswd) 
        {
            return ["status" => "error", "color" => "#ff0000", "message" => "两次输入密码不一致!" ];
        }
        $user->setPassword($passwd);
        if( $user->save() )
        {
            return ["status" => "ok", "color" => "green", "message" => "修改密码成功!" ];
        }
        return ["status" => "error", "color" => "#ff0000", "message" => "系统出错，联系开发人员确认！" ];
    }
    
    /**
     * 修改用户分组
     */
    public function actionUpdateadminug()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $userid = $this->getParam("adminuserid");
        $ugid = $this->getParam("ugid");
        
        if ( $ugid == "0" || $ugid < 0 ) 
        {
            return ["status" => "error","color" => "#ff0000", "message" => "请选择要修改的用户分组！" ];

        } 
        if( !$user = Adminuser::findOne($userid) )
        {
            return ["status" => "error","color" => "#ff0000", "message" => "用户不存在，可能已被其他管理员移除！" ];
        }
        if($user->ugid==$ugid)
        {
            return ["status" => "error","color" => "#ff0000", "message" => "与原分组一样，无需修改！" ];
        }
        $user->ugid = $ugid;
        if( $user->save())
        {
            return ["status" => "ok", "color" => "#008d4c", "message" => "修改分组成功！"];
        }
        return [ "status" => "error", "color" => "#ff0000", "message" => "系统出错，联系开发人员确认！" ,"errormsg"=>$user->getErrors()];
    }
    
    /**
     * 删除管理员
     * @return type
     */
    public function actionDeladmin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $userid = $this->getParam("id");
        
        if( !$user = Adminuser::findOne($userid) )
        {
            return ["status" => "error","color" => "#ff0000", "message" => "用户不存在，可能已被其他管理员移除！","type"=>"error"];
        }
        $user->status = (string)Adminuser::STATUS_DELETED;
        if( $user->save() )
        {
            return ["status" => "ok", "color" => "#008d4c", "message" => "删除成功！","type"=>"success"];
        }
        return [ "status" => "error", "color" => "#ff0000", "message" => "系统出错，联系开发人员确认！","type"=>"error","errormsg"=>$user->getErrors() ];
    }

    /**
     * 管理员列表检索条件
     * @return string
     */
    private function getCond()
    {
        $cond = 1;
        return $cond;
    }
}
