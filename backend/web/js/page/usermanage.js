/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    //新增管理员弹框(弹出后重置用户分组隐藏域)
    $('#adduser_win').on('show.bs.modal', function (event) {
        var modal = $(this);
        
        modal.find("input").val('');
        modal.find('.modal-footer .error-tip').text("");
    });
    
    //编辑管理员弹框(弹出后重置用户分组隐藏域)
    $('#edituser_win').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        
        modal.find('.username').val(button.data('username'));
        modal.find('.email').val(button.data('email'));
        modal.find('.status').val(button.data('status'));
       
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
    
});

//添加管理员
function addUser(obj){
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
        var email = $.trim(modal.find(".email").val());

        if( username === "" ){
            error_tip.css("color","red").text("请输入用户名！");
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
        modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled
        $.ajax({
            type: "POST",
            url: "/usermanage/adduser",
            data:{
                data:{
                    username:username,
                    passwd:passwd,
                    email:email
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
function editUser(obj){
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
        var email = $.trim(modal.find(".email").val());
        var status = $.trim(modal.find(".status").val());

        modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled
        $.ajax({
            type: "POST",
            url: "/usermanage/edituser",
            data:{
                data:{
                    username:username,
                    email:email,
                    status:status
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
        url: "/usermanage/updatepw",
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

