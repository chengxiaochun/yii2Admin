<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<link rel="stylesheet" href="/plugins/powertree/css/powertree.css">
<script src="/plugins/powertree/js/powertree.js"></script>
<script src="/js/page/sysmanage.js"></script>
<!-- 头部标题-->
<section class="content-header">
    <h1>
        系统管理
        <small>功能列表</small>
    </h1>
</section>

<!-- 主体内容 -->
<section class="content" >
    <div class="row">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">功能列表</h3>
                <a href="JavaScript:void(0);"  data-target="#addfuncs_win" data-toggle="modal" class="btn btn-primary pull-right">新增功能</a>
            </div>
            <div class="box-body">
                <ul class="treeview-box">
                    <?php
                    $data = \common\components\Common_class::getfuncs(null, true);
                    \common\components\Common_class::getTreeFuncsList($data);
                    ?>
                </ul>
            </div>
            <div class="box-footer">
                <a href="JavaScript:void(0);"  data-target="#addfuncs_win" data-toggle="modal" class="btn btn-primary pull-right">新增功能</a>
            </div>
        </div>
    </div>
</section>

<!--功能id隐藏域（用于添加功能时选择父级功能，默认为0表示无父级）-->
<input type="hidden" name="fatherfuid" value="0" id="fatherfuid"/>
<!--添加功能弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="addfuncs_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">添加新功能</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>父级功能</label>
                            <div class="col-sm-2 fatherug" style='padding-right: 0'>
                                <select class="form-control" onchange="selchange(this)">
                                    <option value="0" >---无父级---</option>
                                    <?php foreach($funcsfather as $funsvalue){?>
                                        <option value="<?=$funsvalue['fuid']?>"><?=$funsvalue['funame']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>功能名称</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control funcname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>功能url</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control funcurl"  value="###">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>功能排序</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control sort"  value="0">
                            </div>
                            <div class="col-sm-4" style="line-height: 35px;color: #999">
                                <span>注：同级功能数字越小越往前</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">是否显示</label>
                            <div class="col-sm-6">
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio"  value="1" id="" name="addisshowrad">是
                                    </label>
                                </div>
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio" checked="" value="0" id="" name="addisshowrad">否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">是否检测权限</label>
                            <div class="col-sm-6">
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio" checked="" value="1" id="" name="addischeckrad">检测
                                    </label>
                                </div>
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio"  value="0" id="" name="addischeckrad">不检测
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="addFunc(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!--修改功能弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="updatefuncs_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">修改功能</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <!--要修改的功能id-->
                        <input type="hidden"  value="0" class="fuid"/>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>父级功能</label>
                            <div class="col-sm-2 fatherfuc" style='padding-right: 0'>
                                <select class="form-control" onchange="selchange(this)">
                                    <option value="0" >---无父级---</option>
                                    <?php foreach($funcsfather as $funsvalue){?>
                                        <option value="<?=$funsvalue['fuid']?>"><?=$funsvalue['funame']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div  class="col-sm-8 funcselgroup" style="padding-left: 0">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>功能名称</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control funcname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>功能url</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control funcurl" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>功能排序</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" id="" class="form-control sort"  value="0">
                            </div>
                            <div class="col-sm-4" style="line-height: 35px;color: #999">
                                <span>注：同级功能数字越小越往前</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">是否显示</label>
                            <div class="col-sm-6">
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio"  value="1" id="udisshowrad_y" name="udisshowrad">是
                                    </label>
                                </div>
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio" checked="" value="0" id="udisshowrad_n" name="udisshowrad">否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">是否检测权限</label>
                            <div class="col-sm-6">
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio" checked="" value="1" id="udischeckrad_y" name="udischeckrad">检测
                                    </label>
                                </div>
                                <div class="radio col-sm-3">
                                    <label>
                                        <input type="radio"  value="0" id="udischeckrad_n" name="udischeckrad">不检测
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="updateFunc(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>