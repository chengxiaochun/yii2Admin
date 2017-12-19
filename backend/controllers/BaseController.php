<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Adminfuncsurl;
use backend\models\Adminaccess;

/**
 * Base controller
 */
class BaseController extends Controller
{
    public $layout = "mainlayout";

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * 
     * @param type $action
     * @return boolean
     */
    public function beforeAction($action) {
        //parent::beforeAction($action);
        //未登录跳到登录页面
        if( Yii::$app->user->isGuest )
        {
            Yii::$app->response->redirect("/site/login");
            return FALSE;
        }
        $controller_ = Yii::$app->controller->id;           //得到控制器名
        $action_     = Yii::$app->controller->action->id;   //得到方法名
        $url = "/".$controller_."/".$action_;
        if( !$this->checkaccess($url) )
        {
            echo json_encode(array("status"=>"error","message"=>"抱歉您没有该权限！","color"=>"red"));
            exit;
        }
        return TRUE;
    }
    
    /**
     * 验证权限
     */
    private function checkaccess( $url = null )
    {
        $filter = Yii::$app->params["access_url_filter"];     // 不需要验证权限的url
        //未登录
        if( Yii::$app->user->isGuest || empty($url) )
        {
            return false;
        }
        if( in_array($url, $filter) )
        {
            return true;
        }
        $ugid = Yii::$app->user->identity->ugid;
        $funs = Adminfuncsurl::find()
            ->select("fuid,isCheck")
            ->where("fuURL LIKE '$url' AND isDelete=0")
            ->one();
        if( !$funs )
        {
            echo json_encode(array("status"=>"error","message"=>"该url：$url 缺失,请到系统管理中添加","color"=>"red"));
            exit;
        }
        //功能不需要检测
        else if( $funs->isCheck == 0 )
        {
            return true;
        }
        //拥有权限
        else if( Adminaccess::find()->where(["ugid"=>$ugid,"fuid"=>$funs->fuid])->one() )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 获取post/get参数
     * @param string $key
     * @return string/null
     */
    public function getParam($key)
    {
       $res = "";
       if( isset($_POST[$key]) )
       {
           $res = $_POST[$key];
       }
       else if( isset($_GET[$key]) )
       {
           $res = $_GET[$key];
       }
       
       return is_string($res)?trim($res):$res;
    }
}
