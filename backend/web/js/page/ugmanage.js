
$(function () {
    //新增用户组
    $('#addusergroup_win').on('show.bs.modal', function (event) {
        var modal = $(this);
        //重置输入信息
        modal.find('.ugtypename').val("");
        modal.find('.modal-footer .error-tip').text("");
        //重置分组下拉
        resetUgSel(modal);
    })

    //切换组别
    $("input[name='ugtype']").click(function(){
        var isAdmin = $(this).val();
        swichUgtypeByIa(isAdmin);

    })
})

//重置分组下拉选项，并置usergid隐藏域val为0
function resetUgSel(obj){
    obj.find('.fatherug').nextAll().remove();
    obj.find('.fatherug select').val(0);
    $("#ugfatherid").val(0);
}

//添加用户组
function addUg(obj){
    var modal = $(obj).closest(".modal");
    var error_tip = modal.find(".modal-footer .error-tip");
    var ugtypename = modal.find(".ugtypename").val();
    var ugfatherid = $("#ugfatherid").val();
    if( $.trim(ugtypename) === "" ){
        error_tip.css("color","#ff0000").text("用户组名称不能为空！");
        return false;
    }
    $.ajax({
        type: "POST",
        url: "/sysmanage/addusergroup",
        data:{
            data:{
                typename:ugtypename,
                ugfatherid:ugfatherid}
        },
        dataType:"json",
        beforeSend:function(){
        },
        success: function(data)
        {
            error_tip.css("color",data.color).text(data.message);
            if (data.status=="ok"){
                window.location.reload();
            }
        },
        error:function(data)
        {
        }
    });
}


//修改并保存用户组
function saveUg(obj){
    $this = $(obj);
    var typename = $this.closest(".view-item").find(".checkbox .edit-txt").val();
    var ugid = $this.attr("data-ugid");
    if (!$.trim(typename)) {
        $this.closest(".view-item").find(".tips").css("color", "#ff0000").text("不能为空！");
        loadfuncWithRelay('$this.closest(".view-item").find(".tips").text("")');
        return;
    }
    $.post("/sysmanage/updateadminug",{"ugid":ugid,"typename":$.trim(typename)},function(data){
        $this.closest(".view-item").find(".tips").css("color",data.color).text(data.message);
        loadfuncWithRelay('$this.closest(".view-item").find(".tips").text("")');
        if(data.status=="ok"){
            $this.closest(".view-item").find(".checkbox .edit-txt").hide();
            $this.closest(".view-item").find(".checkbox label").show().find(".val").text(typename);

            $this.closest(".view-item").find(".savecancel").hide().siblings(".editdel").show();
        }
    },"json");
}


//删除用户组
function deleteUg(obj){
    $this = $(obj);
    var ugid = $this.attr("data-ugid");
    swal({
        title: '您确定要删除此用户组以及其子用户组吗？',
        type: 'question',
        allowOutsideClick:false,
        showCancelButton:true,
        confirmButtonText: '确定',
        cancelButtonColor: '#d33',
        cancelButtonText: '取消'
    }).then(function() {
        $.post("/sysmanage/deleteadminug",{"ugid":ugid},function(data){
            $this.closest(".view-item").find(".tips").css("color",data.color).text(data.message);
            loadfuncWithRelay('$this.closest(".view-item").find(".tips").text("")');
            if(data.status=="ok"){
                window.location.reload();
            }
        },"json");
    },function(dismiss) {
        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
//        if (dismiss === 'cancel') {
//        }
    });
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
            //alert(data.ugdata[0]['ugid']);

            if(ugid<0){ //选择‘无此级’选项
                ugid =  $this.closest("div").prev().find("select").val();
                $this.closest("div").nextAll().remove();
                $this.closest("div").remove();
            }
            $("#ugfatherid").val(ugid);
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

//切换组别，更新用户分组下拉
function swichUgtypeByIa(isAdmin){

    $.ajax({
        type: "POST",
        url: "/funcs/getfatherugbyia",
        data:{isAdmin:isAdmin},
        dataType:"json",
        beforeSend:function(){

            $("#fatherug").closest("div").nextAll().remove();
            $("#fatherug").prop("disabled",true);
        },
        success: function(data)
        {
            $("#fatherug").prop("disabled",false);
            if(data.status=="ok"){
                var opitemsHtml = "<option value='0'>---无父级---</option>";
                for(var i=0;i<data.fugdata.length;i++){
                    var thugid = data.fugdata[i]['ugid'];
                    var thtypename = data.fugdata[i]['typename'];
                    opitemsHtml += "<option value='"+thugid+"'>"+thtypename+"</option>";
                }

                $("#fatherug").closest("div").nextAll().remove();
                $("#fatherug").html(opitemsHtml);
            }
        },

        error:function(data)
        {

        }

    });

}
