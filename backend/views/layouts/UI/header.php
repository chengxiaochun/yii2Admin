<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$user = \Yii::$app->user->identity;
?>
<header class="main-header">
    <!-- Logo -->
    <a href="/index/index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>系</b>统</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?php echo Yii::$app->params["SYSNAME"];?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img alt="User Image" class="img-circle" src="/AdminLTE/dist/img/user2-160x160.jpg">

                            <p>
                                <small>日期：<?php echo date("Y-m-d") ?></small>
                                <small>您当前登陆的IP地址：<?php echo Yii::$app->request->userIP; ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a class="btn btn-primary btn-flat" href="JavaScript:void(0);" data-target='#updatemypw_win' data-toggle='modal'>修改密码</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-danger btn-flat" href="/site/logout">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>