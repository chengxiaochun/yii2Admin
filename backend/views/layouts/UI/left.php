<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$user = \Yii::$app->user->identity;
$ug   = \backend\models\Adminusergroup::findOne(["ugid"=>$user->ugid,"isDelete"=>0]); //用户所在组
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $user->username;?></p>
                <!-- Status -->
                <a href="javascript:void(0);"><i class="fa fa-credit-card text-success"></i><?php echo $ug ? $ug->typename : "无";?></a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">导 航 菜 单</li>
            <ul id="tree" class="ztree" style="overflow:auto;"></ul>
            <?php
            //表达式依赖  
            $exdp = new yii\caching\ExpressionDependency([
                'expression' => $user->ugid
            ]);
            //db依赖
            $dbdp = new yii\caching\DbDependency(['sql' => 'SELECT MAX(id) FROM menufcache']);
            $dependencies = new yii\caching\ChainedDependency(['dependencies' => [$exdp, $dbdp]]);
                
             if( $this->beginCache("left_menu",["dependency"=>$dependencies,'duration' => 1800]) )
             {
                //左侧导航树
                //echo "date:".date("Y-m-d H:i:s");
                $data = \common\components\Common_class::getfuncs($user->ugid);
                \common\components\Common_class::getTreeMenu($data);
                $this->endCache();
             }
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
