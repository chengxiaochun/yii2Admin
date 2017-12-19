/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    //新增管理员弹框(弹出后重置用户分组隐藏域)
    $('#addadmin_win').on('show.bs.modal', function (event) {
        var modal = $(this);
        
        modal.find("input").val('');
        modal.find('.modal-footer .error-tip').text("");
        //重置分组下拉
        resetUgSel(modal);
    });
    
    //编辑管理员弹框(弹出后重置用户分组隐藏域)
    $('#editadmin_win').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        
        modal.find('.username').val(button.data('username'));
        modal.find('.mobilNo').val(button.data('mobilno'));
        modal.find('.userbasestate').val(button.data('userbasestate'));
       
        modal.find('.modal-footer .error-tip').text("");
    });
    
        //修改密码弹框(弹出后赋值用户名并重置弹框内容)
    $('#updatepw_win').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var username = button.data('username');
        var modal = $(this);
        modal.find('.up-username').text(username);
        modal.find('.up-passwd').val("");
        modal.find('.up-repasswd').val("");
        modal.find('.modal-footer .error-tip').text("");
        modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
    });
    
    //修改用户分组()
    $('#updateug_win').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var adminuserid = button.data('adminuserid');
        var username = button.data('username');
        var ugid = button.data('ugid');
        var typename = button.data('typename');
        var modal = $(this);
        modal.find('.username').text(username);
        modal.find('.oldug').text(typename);
        modal.find('.adminuserid').val(adminuserid);
        modal.find('.modal-footer .error-tip').text("");
        modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
        //重置分组下拉
        resetUgSel(modal);
    });
});

//重置分组下拉选项，并置usergid隐藏域val为0
function resetUgSel(obj){
    obj.find('.fatherug').nextAll().remove();
    obj.find('.fatherug select').val(0);
    $("#usergid").val(0);
}

//多级联动
function selchange(obj){
    var $this = $(obj);
    var ugid = $this.val();
    $.ajax({
        type: "POST",
        url: "/admin/admingroup",
        data:{ugid:ugid},
        dataType:"json",
        beforeSend:function(){
        },
        success: function(data)
        {
            if(ugid<0){ //选择‘无此级’选项
                ugid =  $this.closest("div").prev().find("select").val();
                $this.closest("div").nextAll().remove();
                $this.closest("div").remove();
            }
            $("#usergid").val(ugid);
            $this.closest("div").nextAll().remove();
            if(data.status=="ok"){
                var opitemsHtml = "<option value='-1'>---无此级---</option>";
                for(var i=0;i<data.ugdata.length;i++){
                    var thugid = data.ugdata[i]['ugid'];
                    var thtypename = data.ugdata[i]['typename'];
                    opitemsHtml += "<option value='"+thugid+"'>"+thtypename+"</option>";
                }
                $this.closest("div").after("<div class='col-sm-2' style='padding-right: 0'><select  class='form-control' onchange='selchange(this)'>"+opitemsHtml+"</select></div>");
            }
        },
        error:function(data)
        {
        }
    });
}

//添加管理员
function addAdmin(obj){
    swal({
        title: '确定添加么？',
        type: 'question',
        allowOutsideClick:false,
        showCancelButton:true,
        confirmButtonText: '确定',
        cancelButtonColor: '#d33',
        cancelButtonText: '取消'
    }).then(function() {
        var modal = $(obj).closest(".modal");
        var error_tip = modal.find(".modal-footer .error-tip");
        error_tip.text("");
        //$("#adduser_win").find("")
        var username = $.trim(modal.find(".username").val());
        var passwd = $.trim(modal.find(".passwd").val());
        var repasswd = $.trim(modal.find(".repasswd").val());
        var mobilNo = $.trim(modal.find(".mobilNo").val());
        var ugid = $.trim(modal.find(".ugid").val());

        if( username === "" ){
            error_tip.css("color","red").text("请输入管理员用户名！");
            return false;
        }
        if( passwd.length < 4 ){
            error_tip.css("color","red").text("密码位数必须大于等于4位！");
            return false;
        }

        if( passwd !== repasswd ){
            error_tip.css("color","red").text("两次输入密码不一样！");
            return false;
        }
        if( parseInt(ugid) <= 0 ){
            error_tip.css("color","red").text("请选择分组！");
            return false;
        }
        modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled
        $.ajax({
            type: "POST",
            url: "/admin/addadmin",
            data:{
                data:{
                    username:username,
                    passwd:passwd,
                    mobilNo:mobilNo,
                    ugid:ugid
                }
            },
            dataType:"json",
            beforeSend:function(){
            },
            success: function(data)
            {
                error_tip.css("color",data.color).text(data.message);
                modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
                
                if( "ok" === data.status ){
                    datatable.ajax.reload(null,false);
                    loadfuncWithRelay(function(){
                        modal.modal("hide");
                    });
                }
            },
            error:function(data)
            {
                error_tip.css("color","red").text("系统出错，联系开发人员确认！");
                modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            }
        });
    }, function(dismiss) {
        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
        if (dismiss === 'cancel') {
            //$(obj).closest(".modal").modal("hide");
        }
    });
}

//编辑管理员
function editAdmin(obj){
    swal({
        title: '确定修改么？',
        type: 'question',
        allowOutsideClick:false,
        showCancelButton:true,
        confirmButtonText: '确定',
        cancelButtonColor: '#d33',
        cancelButtonText: '取消'
    }).then(function() {
        var modal = $(obj).closest(".modal");
        var error_tip = modal.find(".modal-footer .error-tip");
        error_tip.text("");
        var username = $.trim(modal.find(".username").val());
        var mobilNo = $.trim(modal.find(".mobilNo").val());
        var userbasestate = $.trim(modal.find(".userbasestate").val());

        modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled
        $.ajax({
            type: "POST",
            url: "/admin/editadmin",
            data:{
                data:{
                    username:username,
                    mobilNo:mobilNo,
                    userbasestate:userbasestate
                }
            },
            dataType:"json",
            beforeSend:function(){
            },
            success: function(data)
            {
                error_tip.css("color",data.color).text(data.message);
                modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
                
                if( "ok" === data.status ){
                    datatable.ajax.reload(null,false);
                    loadfuncWithRelay(function(){
                        modal.modal("hide");
                    });
                }
            },
            error:function(data)
            {
                error_tip.css("color","red").text("系统出错，联系开发人员确认！");
                modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            }
        });
    }, function(dismiss) {
        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
        if (dismiss === 'cancel') {
            //$(obj).closest(".modal").modal("hide");
        }
    });
}

//修改密码
function updatePw(obj){
    var modal = $(obj).closest(".modal");
    var error_tip = modal.find(".modal-footer .error-tip")
    var username = modal.find(".up-username").text();
    var passwd = $.trim(modal.find(".up-passwd").val());
    var repasswd = $.trim(modal.find(".up-repasswd").val());
    
    if( passwd.length < 4 )
    {
        error_tip.css("color","red").text("密码位数不能少于4位！");
        return;
    }
    if( passwd !== repasswd )
    {
        error_tip.css("color","red").text("两次输入密码不一致！");
        return;
    }
    modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled
    $.ajax({
        type: "POST",
        url: "/admin/updatepw",
        data:{username:username,passwd:passwd,repasswd:repasswd},
        dataType:"json",
        beforeSend:function(){

        },
        success: function(data)
        {
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            error_tip.css("color",data.color).text(data.message);
            if( "ok" === data.status )
            {
                loadfuncWithRelay(function(){
                        modal.modal("hide");
                    });
            }
        },
        error:function(data)
        {
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            error_tip.css("color","red").text("系统出错，联系开发人员确认！");
        }
    });
}

//修改用户分组
function updateAdminug(obj){
    var ugid = $("#usergid").val();
    var modal = $(obj).closest(".modal");
    var error_tip = modal.find(".modal-footer .error-tip");
    var adminuserid = modal.find(".adminuserid").val();
    
    if( parseInt(ugid) === 0 ){
        error_tip.css("color","red").text("请选择要修改的用户分组！");
        return false;
    }
    modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled
    $.ajax({
        type: "POST",
        url: "/admin/updateadminug",
        data:{adminuserid:adminuserid,ugid:ugid},
        dataType:"json",
        beforeSend:function(){
        },
        success: function(data)
        {
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            error_tip.css("color",data.color).text(data.message);
            if ( data.status === "ok" ){
                datatable.ajax.reload(null,false);
                loadfuncWithRelay(function(){
                        modal.modal("hide");
                    });
            }
        },
        error:function(data)
        {
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            error_tip.css("color","red").text("系统出错，联系开发人员确认！");
        }
    });
}

function delAdmin(id)
{
    swal({
        title: '确定要删除该用户么？',
        type: 'question',
        allowOutsideClick:false,
        showCancelButton:true,
        confirmButtonText: '确定',
        cancelButtonColor: '#d33',
        cancelButtonText: '取消'
    }).then(function() {
        $.post("/admin/deladmin",{"id":id},function(data){
            swal({
                title: data.message,
                type: data.type?data.type:"warning",
                showCloseButton:true,
                allowOutsideClick:true,
            }); 
            if( data.status==="ok" ){
                datatable.ajax.reload(null,false);
            }
        },"json");
    },function(dismiss) {
        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
//        if (dismiss === 'cancel') {
//        }
    });
}

