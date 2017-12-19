<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\controllers\BaseController;
use backend\models\Adminfuncsurl;
use backend\models\Adminaccess;
use backend\models\Adminusergroup;

/**
 * Sysmanage controller
 */
class SysmanageController extends BaseController
{
    public function beforeAction($action) {
        parent::beforeAction($action);
        $menufcache = \backend\models\Menufcache::find()->where("1")->one();
        if( in_array(Yii::$app->controller->action->id, ["updatepower","modifyfuncs"]) && $menufcache )
        {
            $menufcache->id++;
            $menufcache->save();
        }
        else if( !$menufcache )
        {
            $menufcache = new \backend\models\Menufcache();
            $menufcache->save();
        }
        return TRUE;
    }

    /**
     * 功能列表
     */
    public function actionAdminfunclist()
    {
        $funcs = Adminfuncsurl::find()->where("fatherfuid=0 AND isDelete=0")->asArray()->all();
        return $this->render("adminfunclist",["funcsfather"=>$funcs]);
    }
    
    /**
     * 添加功能
     */
    public function actionAddfunc()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        $data["funame"] = $this->getParam("funame");
        $data["fatherfuid"] = $this->getParam("fatherfuid");
        $data["fuURL"] = $this->getParam("fuURL");
        $data["isShow"] = $this->getParam("isShow");
        $data["isCheck"] = $this->getParam("isCheck");
        $data["sort"] = $this->getParam("sort");
        
        return Adminfuncsurl::add($data);
    }
    
    /**
     * 修改功能
     * @return type
     */
    public function actionModifyfuncs()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        $data["fuid"] = $this->getParam("fuid");
        $data["funame"] = $this->getParam("funame");
        $data["fatherfuid"] = $this->getParam("fatherfuid");
        $data["fuURL"] = $this->getParam("fuURL");
        $data["isShow"] = $this->getParam("isShow");
        $data["isCheck"] = $this->getParam("isCheck");
        $data["sort"] = $this->getParam("sort");
        
        return Adminfuncsurl::modify($data,["fuid"=>$data["fuid"]]);
    }
    
    /**
     * 管理员授权界面
     */
    public function actionAdminauth()
    {
        return $this->render("adminauth");
    }
    
    /**
     *后台用户组管理
     */
    public function actionAdminug()
    {
        //用户分组
        $ugArr = Adminusergroup::getList(null,"ugfatherid=0 AND isDelete='0'")->asArray()->all();
        return $this->render("adminug", ["ugfather"=>$ugArr]);
    }
    
    /**
     * 修改后台用户组
     */
    public function actionUpdateadminug()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ugid = $this->getParam("ugid");
        $typename = $this->getParam("typename");
        
        $usergroup = Adminusergroup::findOne($ugid);
        if( !$usergroup )
        {
            return ["status"=>"error","message"=>"修改失败","color"=>"red"];
        }
        $usergroup->typename = $typename;
        if( $usergroup->save() )
        {
            return ["status"=>"ok","message"=>"修改成功！","color"=>"green"];
        }
        return ["status"=>"error","message"=>"修改失败","color"=>"red"];
    }
    
    /**
     * 添加后台用户组
     */
    public function actionAddusergroup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Adminusergroup::add($this->getParam("data"));
    }
    
        /**
     * 删除用户组
     */
    public function actionDeleteadminug()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ugid = $this->getParam("ugid");
        if( !Adminusergroup::iscandel($ugid) )
        {
            return ["status"=>"error","message"=>"用户组或其子组下存在用户，请迁移后再删除！","color"=>"red"];
        }
        $transaction = Adminusergroup::getDb()->beginTransaction();
        $delres = Adminusergroup::del($ugid);
        if( $delres == "ok" )
        {
            $transaction->commit();
            return ["status"=>"ok","message"=>"删除成功！","color"=>"green"];
        }
        else
        {
            $transaction->rollBack();
            return ["status"=>"error","message"=>"系统出错，请联系开发人员！","color"=>"red"];
        }
    }
    
    /**
     * 根据用户组ugid获取对应授权功能集合
     */
    public function actionGetfunsbyugid()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $ugid = $this->getParam("ugid");
        if(empty($ugid)){
            return ['status' => 'erorr'];
        }
        $res = Adminaccess::find()->select("fuid")->where(["ugid"=>$ugid])->asArray()->all();
        if(!empty($res)){
            return [ 'status' => 'ok', 'message' => $res];
        }
        return ['status' => 'erorr'];
    }
    
    /**
     * 保存授权
     */
    public function actionUpdatepower()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        //获得参数,$arr_fuid为fuid组成的数组
        $ugid = $this->getParam('ugid');
        $arr_fuid = json_decode($this->getParam('arr_fuid'));

        if( $ugid < 0 || !ctype_digit($ugid) )
        {
            return [ 'status' => 'erorr',"color" => "#ff0000",'message'=> '修改权限失败！'];
        }
        if( Adminaccess::ugauthorize($ugid, $arr_fuid) )
        {
            return ['status' => 'ok',"color" => "#008d4c", 'message'=> '修改权限成功！'];
        }
        else
        {
            return [ 'status' => 'erorr', "color" => "#ff0000",'message'=> '修改权限失败！'];
        }
    }

    /**
     * 图标
     */
    public function actionShowicons()
    {
        return $this->render("icons");
    }
    
    /**
     * 根据传入的fatherfuid获取对应父级fuid
     */
    public function actionGetfatherfuid()
    {
        $fatherfuid = $this->getParam('fatherfuid');
        if($fatherfuid==0 || $fatherfuid=='0'){
            return 0;
        }
        $fcArr = Adminfuncsurl::findone($fatherfuid);
        if (!$fcArr) {
            return 0;
        } else{
            return $fcArr->fatherfuid;
        }
    }
    
    /**
     * 功能多级联动
     */
    public function actionFuncsgroup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//设置响应格式为json
        $fatherfuid = $this->getParam('fatherfuid');
        if($fatherfuid==0 || $fatherfuid=='0'){
            return $resArr = array(  "status" => "no" );
        }
        $fcArr = Adminfuncsurl::find()->where(["fatherfuid"=>$fatherfuid,"isDelete"=>0])->asArray()->all();
        if (empty($fcArr)) {
            $resArr = array(
                "status" => "no"
            );
        } else {
            $resArr = array(
                "status" => "ok",
                "fcdata" => $fcArr
            );
        }
        return $resArr;
    }
}
