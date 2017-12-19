<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 系统管理
 */

namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\controllers\BaseController;
use backend\models\Userbase;

class UsermanageController extends BaseController
{
    /**
     * 用户列表
     */
    public function actionUserlist()
    {
        //获取列表数据
        if( Yii::$app->request->get("data") == "getdata" )
        {
            Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
            $draw   = Yii::$app->request->post("draw");         //前端向服务器请求的次数
            $start  =  Yii::$app->request->post('start');       //从多少开始
            $length = Yii::$app->request->post('length');       //每页显示多少条
            $cond   = $this->getUserCond();
            
            $resdata = Userbase::find()
                ->select("userid,username,email,status,created_at")
                ->where($cond)
                ->orderBy("created_at DESC");
//                     ->createCommand();
//            echo $resdata->sql;
//            exit;
            $count   = $resdata->count();
            $data    = $resdata->offset($start)->limit($length?$length:10)->asArray()->all();
            
            return array("draw"=>$draw,"recordsFiltered"=>$count,"data"=>$data);
        }
        //呈现视图
        else
        {
            return $this->render("userlist");
        }
    }
    
    /**
     * 添加新用户
     */
    public function actionAdduser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Userbase::add($this->getParam("data"));
    }
    
    /**
     * 编辑用户
     */
    public function actionEdituser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = $this->getParam("data");
        $cond = ["username"=>$data["username"]];
        unset($data["username"]);
        return Userbase::modify($data,$cond);
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
        $user = Userbase::findByUsername($username);
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
     * 获取用户列表检索条件
     * @return string
     */
    private function getUserCond()
    {
        $cond = "1";
        $search = $this->getParam("search");
        $value = trim($search["value"],"\'");
        if( !empty($value) )
        {
            $cond .= " AND username LIKE '$value%'";
        }
        return $cond;
    }
    
}

