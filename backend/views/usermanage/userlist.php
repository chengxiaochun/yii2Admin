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
<script src="/js/page/usermanage.js"></script>

<!-- 头部标题-->
<section class="content-header">
    <h1>
        用户管理
        <small>用户列表</small>
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
                            <a href="###"  data-target="#adduser_win" data-toggle="modal" class="col-xs-6 btn btn-block btn-success">新增用户</a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="userlist" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>用户名</th>
                            <th>邮箱</th>
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
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="adduser_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">添加用户</h4>
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
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>邮箱</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="邮箱" id="" class="form-control email">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="addUser(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--编辑弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="edituser_win">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">编辑用户</h4>
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
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>邮箱</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="邮箱" id="" class="form-control email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for=""><span class="color-red"></span>状态</label>
                            <div class="col-sm-2">
                                <select class="form-control status">
                                    <option value="10">正常</option>
                                    <option value="0">冻结</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="editUser(this)">确定</button>
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

<!-- page script -->
<script>
    var datatable=null;
    $(function () {
        datatable = $("#userlist").DataTable({

            processing: true,
            serverSide: true,
            iDisplayLength:25,
            searchDelay: 1000,
            pagingType: "full_numbers",
            ordering:false,
            //searching:false,
            ajax:{
                url:'/usermanage/userlist?data=getdata',
                type:'post'
            },
            aoColumns:[
                {"data":"username"},
                {"data":"email"},
                {"data":null,render:function(data){
                     switch(parseInt(data["status"]))
                     {
                        case 10: return "正常";
                        case 0: return "冻结";
                        default:return "冻结";
                     }
                }},
                {"data":"created_at"},
                {"data":null,render:function(data, type, row){
                    return "<a href='javascript:void(0);' class='btn btn-primary margin-r-5' data-target='#edituser_win' data-toggle='modal' data-username='"+data['username']+
                            "' data-email='"+data['email']+"' data-status='"+data['status']+"'>编辑</a>"+
                            "<a href='javascript:void(0);' class='btn btn-success margin-r-5' data-target='#updatepw_win' data-toggle='modal' data-username='"+data['username']+"'>修改密码</a>";
//                            "<a href='javascript:void(0);' class='btn btn-danger margin-r-5' onclick='delUser("+data["userid"]+")' >删除</a>";     
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