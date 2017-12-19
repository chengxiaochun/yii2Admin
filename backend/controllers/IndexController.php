<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class IndexController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * 后台首页
     * @return type
     */
    public function actionIndex()
    {
        return $this->render("index");
    }
    
    /**
     * 修改个人密码
     * @return type
     */
    public function actionResetpwd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $pwd1 = $this->getParam("pwd1");
        $pwd2 = $this->getParam("pwd2");
        
        if( strlen($pwd1) < 4 )
        {
            return ["status"=>"error","message"=>"密码必须大于等于4位","color"=>"red"];
        }
        if( $pwd1 != $pwd2 )
        {
             return ["status"=>"error","message"=>"两次输入密码不一样","color"=>"red"];
        }
        $user = Yii::$app->user->identity;
        $user->setPassword($pwd1);

        if( !$user->save() )
        {
            return ["status"=>"error","message"=>"系统出错，联系开发人员","color"=>"red"];
        }
        return ["status"=>"ok","message"=>"修改成功，请牢记！","color"=>"green"];
    }
}
