<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<link rel="stylesheet" href="/plugins/powertree/css/powertree.css">
<script src="/plugins/powertree/js/powertree.js"></script>
<script src="/js/page/ugmanage.js"></script>
<!-- 头部标题-->
<section class="content-header">
    <h1>
        系统管理
        <small>后台用户组管理</small>
    </h1>
</section>

<!--添加新用户组-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="addusergroup_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">添加后台用户组</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>父级用户组</label>

                            <div class="col-sm-2 fatherug" style='padding-right: 0'>
                                <select class="form-control" id="fatherug" onchange="selchange(this)">
                                    <option value="0">---无父级---</option>
                                    <?php foreach ($ugfather as $ugvalue) { ?>
                                        <option value="<?= $ugvalue['ugid'] ?>"><?= $ugvalue['typename'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>用户组名称</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control ugtypename">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="addUg(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!--用户组id隐藏域（用于添加用户组时选择父级功能，默认为0表示无父级）-->
<input type="hidden" name="ugfatherid" value="0" id="ugfatherid"/>
<!-- 主体内容 -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-1 btn-fixed-width130">
                            <a href="###" data-target="#addusergroup_win" data-toggle="modal"
                               class="btn btn-block btn-success">新增后台组</a>
                        </div>
                    </div>

                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-warning">
                                <div class="box-header with-border"><h3 class="box-title">分组列表</h3></div>
                                <div class="box-body">
                                    <ul class="treeview-box nocb">
                                        <?php
                                        $data = \common\components\Common_class::getUsegroup();
                                        \common\components\Common_class::getTreeUsergroup($data);
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>