
$(function () {


})

//根据ugid获取对应的授权功能列表
function empower(obj){
    var $this = $(obj);
    var ugid = $this.attr("data-ugid");
    $("#thisugid").val(ugid);
    $("#funcsWin").find(".box-footer .error-tip").text("");//清空提示信息
    $.post("/sysmanage/getfunsbyugid",{ugid:ugid},function(data){
        $("#funcsWin").show(); //显示功能列表
        $("input[name='funcbox']").removeAttr("checked"); //清空功能列表选中项
        if(data.status=="ok"){
            for(var i=0;i<data.message.length;i++){
                var fuid = data.message[i]['fuid'];
                $("input[name='funcbox'][value='"+fuid+"']").prop("checked","true");
            }
        }
    },"json")

}

//保存授权
function savePower(){
    var ugid = $("#thisugid").val();
    var arr_fuid = "["; //功能fuid集合字符串
    var arr_fuid_length = $("input[name='funcbox']:checked").length;
    $("input[name='funcbox']:checked").each(function(){
        arr_fuid += $(this).val()+",";
    })
    if(arr_fuid_length>0){
        arr_fuid = arr_fuid.substr(0,arr_fuid.length-1);
    }
    arr_fuid += "]";
    if(!ugid){
        return;
    }

    $.post("/sysmanage/updatepower",{ugid:ugid,arr_fuid:arr_fuid},function(data){
        $("#funcsWin").find(".box-footer .error-tip").css("color",data.color).text(data.message);
        if(data.status=="ok"){
            loadfuncWithRelay('$("#funcsWin").find(".box-footer .error-tip").text("")');
        }
    },"json")
}

//取消授权
function cancelPower(){
    $("#funcsWin").hide(); //隐藏功能列表
}