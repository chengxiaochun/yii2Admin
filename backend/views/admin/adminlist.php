<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<link rel="stylesheet" href="<?php echo \Yii::$app->params["datatablesrc"]["css"];?>">
<!-- DataTables -->
<script src="<?php echo \Yii::$app->params["datatablesrc"]["datatables"];?>"></script>
<script src="<?php echo \Yii::$app->params["datatablesrc"]["bootstrap"];?>"></script>
<script src="/js/page/admin.js"></script>

<!-- 头部标题-->
<section class="content-header">
    <h1>
        用户管理
        <small>管理员列表</small>
    </h1>
</section>

<!-- 主体内容 -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-1 btn-fixed-width130">
                            <a href="###"  data-target="#addadmin_win" data-toggle="modal" class="col-xs-6 btn btn-block btn-success">新增管理员</a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="sportroomlist" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>用户名</th>
                            <th>属于分组</th>
                            <th>手机</th>
                            <th>状态</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

<!--添加弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="addadmin_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">添加管理员</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>用户名</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="用户名" id="" class="form-control username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>密码</label>
                            <div class="col-sm-10">
                                <input type="password" placeholder="密码" id="" class="form-control passwd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>确认密码</label>
                            <div class="col-sm-10">
                                <input type="password" placeholder="再次输入密码" id="" class="form-control repasswd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>手机号码</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="手机号码" id="" class="form-control mobilNo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>用户分组</label>
                            <input type="hidden" placeholder="用户分组" id="usergid" class="form-control ugid">
                            <div class="col-sm-2 fatherug" style='padding-right: 0'>
                                <select class="form-control" onchange="selchange(this)">
                                    <option value="0" selected>---请选择---</option>
                                    <?php foreach($ugfather as $ugfvalue){?>
                                        <option value="<?=$ugfvalue['ugid']?>"><?=$ugfvalue['typename']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="addAdmin(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--编辑弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="editadmin_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">编辑管理员</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red">*</span>用户名</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="用户名" id="" class="form-control username" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>手机号码</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="手机号码" id="" class="form-control mobilNo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>状态</label>
                            <div class="col-sm-2">
                                <select class="form-control userbasestate">
                                    <option value="0">正常</option>
                                    <option value="1">冻结</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="editAdmin(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--修改密码弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="updatepw_win">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">修改用户密码</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">用户名</label>
                            <div class="col-sm-10">
                                <span  class="form-control up-username"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">新密码</label>
                            <div class="col-sm-10">
                                <input type="password" placeholder="请输入新密码" class="form-control up-passwd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">确认密码</label>
                            <div class="col-sm-10">
                                <input type="password" placeholder="再次输入密码" class="form-control up-repasswd">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="updatePw(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--修改用户分组弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="updateug_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">修改用户分组</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form class="form-horizontal">
                        <!--要修改的用户id-->
                        <input type="hidden"  value="0" class="adminuserid"/>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">用户名</label>
                            <div class="col-sm-10">
                                <span  class="form-control username"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">原始用户分组</label>
                            <div class="col-sm-10">
                                <span  class="form-control oldug"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">修改用户分组</label>
                            <div class="col-sm-2 fatherug" style='padding-right: 0'>
                                <select class="form-control" onchange="selchange(this)">
                                    <option value="0" selected>---请选择---</option>
                                    <?php foreach($ugfather as $ugfvalue){?>
                                        <option value="<?=$ugfvalue['ugid']?>"><?=$ugfvalue['typename']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="updateAdminug(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- page script -->
<script>
    var datatable=null;
    $(function () {
        datatable = $("#sportroomlist").DataTable({

            processing: true,
            serverSide: true,
            iDisplayLength:25,
            searchDelay: 1000,
            pagingType: "full_numbers",
            ordering:false,
            //searching:false,
            ajax:{
                url:'/admin/adminlist?data=getdata',
                type:'post'
            },
            aoColumns:[
                {"data":"username"},
                {"data":"typename"},
                {"data":"mobilNo"},
                {"data":null,render:function(data){
                     switch(parseInt(data["userbasestate"]))
                     {
                        case 0: return "正常";
                        case 1: return "冻结";
                        default:return "冻结";
                     }
                }},
                {"data":"created_at"},
                {"data":null,render:function(data, type, row){
                    return "<a href='javascript:void(0);' class='btn btn-primary margin-r-5' data-target='#editadmin_win' data-toggle='modal' data-username='"+data['username']+
                            "' data-mobilno='"+data['mobilNo']+"' data-userbasestate='"+data['userbasestate']+"'>编辑</a>"+
                            "<a href='javascript:void(0);' class='btn btn-success margin-r-5' data-target='#updatepw_win' data-toggle='modal' data-username='"+data['username']+"'>修改密码</a>"+
                            "<a href='javascript:void(0);' class='btn btn-warning margin-r-5' data-target='#updateug_win' data-toggle='modal' data-adminuserid='"+data['adminuserid']+"' data-username='"+data['username']+
                            "' data-typename='"+data['typename']+"' data-ugid='"+data['ugid']+"'>修改分组</a>"+
                            "<a href='javascript:void(0);' class='btn btn-danger margin-r-5' onclick='delAdmin("+data["adminuserid"]+")' >删除</a>";     
                }}
            ],
            "oLanguage" : {
                "sProcessing" : "正在加载中......",
                "sLengthMenu" : "每页显示 _MENU_ 条记录",
                "sZeroRecords" : "没有数据！",
                "sEmptyTable" : "表中无数据存在！",
                "sInfo" : "当前第 _START_ 到 _END_ 条，共 _TOTAL_ 条",
                "sInfoEmpty" : "显示0到0条记录",
                "sInfoFiltered" : "",
                "oPaginate" : {
                    "sFirst" : "首页",
                    "sPrevious" : "上一页",
                    "sNext" : "下一页",
                    "sLast" : "末页"
                },
                "sSearch":"搜索:",
                "sSearchPlaceholder":"用户名"
            }
        });
    });
</script>