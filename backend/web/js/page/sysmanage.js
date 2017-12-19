$(function(){
    //添加功能弹框
    $('#addfuncs_win').on('show.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.funcname').val("");
        modal.find('.funcurl').val("###");
        modal.find("input[name='addisshowrad']").eq(1).prop("checked",true);
        modal.find("input[name='addischeckrad']").eq(0).prop("checked",true);
        //清空提示信息
        modal.find('.modal-footer .error-tip').text("");
        modal.find(".btn-primary").removeAttr("disabled");
        //重置父级功能为默认值
        modal.find('.fatherug').nextAll().remove();
        modal.find('.fatherug select').val(0);
        $("#fatherfuid").val(0);
    });
    //修改功能弹框
    $('#updatefuncs_win').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var fuid = button.data('fuid');
        var funame = button.data('funame');
        var fuURL = button.data('fuurl');
        var fatherfuid = button.data('fatherfuid');
        var fatherfuname = button.data('fatherfuname');
        var isShow = button.data('isshow');
        var isCheck = button.data('ischeck');
        var modal = $(this);
        //重置父级功能为当前选择的
        resetUgSel(modal,fatherfuid);
        //赋值给修改框
        modal.find('.fuid').val(fuid);
        modal.find('.funcname').val(funame);
        modal.find('.fatherfuname').text(fatherfuname===""||fatherfuname===null?"无":fatherfuname);
        modal.find('.funcurl').val(fuURL);
        modal.find('.sort').val(button.data('sort'));
        isShow?$("#udisshowrad_y").prop("checked",true):$("#udisshowrad_n").prop("checked",true);
        isCheck?$("#udischeckrad_y").prop("checked",true):$("#udischeckrad_n").prop("checked",true);
        modal.find('.modal-footer .error-tip').text("");
    });
    
    //修改系统配置信息
    $("#parameterconfbox .box-header .btn").click(function(){
        $(this).hide();
        $(this).closest(".box-header").next(".form-horizontal").find("input,select,textarea").removeAttr("disabled");
        $(this).closest(".box-header").next(".form-horizontal").find(".box-footer").removeClass("hidden");
    });
    //取消修改系统配置信息
    $("#parameterconfbox .box-footer .btn-default").click(function () {
        window.location.reload();
        $(this).closest(".form-horizontal").prev(".box-header").find(".btn").show();
        $(this).closest(".form-horizontal").find("input,select").attr("disabled","true");
        //$(this).closest(".box-footer").addClass("hidden");
    });
    
    $("#friedFishfriedFishTime_win").on('show.bs.modal', function (event) {
        var modal = $(this);
        var button = $(event.relatedTarget);
        var title_ahead = modal.find(".title_ahead");
        var data = $.parseJSON($("#friedFishTimeId").attr("data-data"));
        var next = '';
        var isdisabled = button.data("showtype")==="show"?"disabled":null;  //显示方式为查看则编辑框不能修改
        if( !isdisabled )
        {
            modal.find(".modal-footer").show();
        }
        else
        {
            modal.find(".modal-footer").hide();
        }
        //modal.find(".btn btn-primary").r("disabled",isdisabled?true:false);
        //列出数据
        for( var k in data )
        {
            next +='<div class="form-group">'+
                        '<div class="col-sm-4"><input type="text" value="'+data[k][0]+'" class="form-control key" '+isdisabled+' /></div>'+
                        '<div class="col-sm-4"><input type="text" value="'+data[k][1]+'" class="form-control value" '+isdisabled+' /></div>'+
                    '</div>';
        }
        title_ahead.html(next);
        modal.find(".box-footer .error-tip").text("");
    });
});

//重置父级功能下拉选项，重置父级功能为当前选择的
function resetUgSel(obj,fatherfuid){
    obj.find('.funcselgroup').html("");
    $("#fatherfuid").val(fatherfuid);
    getFuncsByFatherfuid(obj,fatherfuid);

}

/**
 * 根据给定的fatherfuid获取并显示所属父级功能（用于“修改功能”显示当前功能所属父级功能）
 * @param obj  需要处理的父级功能下拉组所在div
 * @param fatherfuid  当前的功能的fatherfuid
 */
function  getFuncsByFatherfuid(obj,fatherfuid){
    $.ajax({
        type: "POST",
        url: "/sysmanage/getfatherfuid",
        data:{fatherfuid:fatherfuid},
        dataType:"text",
        success: function(data)
        {
            if(data!=0){
                $.post("/sysmanage/funcsgroup",{fatherfuid:data},function(fgres){
                    if(fgres.status=="ok"){
                        var opitemsHtml = "<option value='-1'>---无此级---</option>";
                        for(var i=0;i<fgres.fcdata.length;i++){

                            var thfcid = fgres.fcdata[i]['fuid'];
                            var thfcname = fgres.fcdata[i]['funame'];
                            if(thfcid==fatherfuid){
                                opitemsHtml += "<option selected value='"+thfcid+"'>"+thfcname+"</option>";
                            }else{
                                opitemsHtml += "<option value='"+thfcid+"'>"+thfcname+"</option>";
                            }
                        }
                        obj.find('.funcselgroup').prepend("<div class='col-sm-4' style='padding-right: 0'><select  class='form-control' onchange='selchange(this)'>"+opitemsHtml+"</select></div>");

                    }
                },"json");
                getFuncsByFatherfuid(obj,data);
            }
            obj.find('.fatherfuc select').val(fatherfuid);
        }
    });
}



//功能多级联动（选择父级功能）
function selchange(obj){

    var $this = $(obj);
    var fatherfuid = $this.val();

    $.ajax({
        type: "POST",
        url: "/sysmanage/funcsgroup",
        data:{fatherfuid:fatherfuid},
        dataType:"json",
        beforeSend:function(){

        },
        success: function(data)
        {
            if(fatherfuid==-1){ //选择‘无此级’选项
                fatherfuid =  $this.closest("div").prev().find("select").val();
                $this.closest("div").nextAll().remove();
                $this.closest("div").remove();
            }
            $("#fatherfuid").val(fatherfuid);
            //如果父级功能val=0，即一级功能时，功能链接url为###，且不可修改
            //if(fatherfuid>0){
            //    $this.closest(".form-group").siblings().find(".funcurl").removeAttr("disabled");
            //}
            //else{
            //    $this.closest(".form-group").siblings().find(".funcurl").attr("disabled","true").val("###");
            //}
            $this.closest("div").nextAll().remove();
            if(data.status=="ok"){
                var opitemsHtml = "<option value='-1'>---无此级---</option>";
                for(var i=0;i<data.fcdata.length;i++){
                    var thfcid = data.fcdata[i]['fuid'];
                    var thfcname = data.fcdata[i]['funame'];
                    opitemsHtml += "<option value='"+thfcid+"'>"+thfcname+"</option>";
                }
                $this.closest("div").after("<div class='col-sm-2' style='padding-right: 0'><select  class='form-control' onchange='selchange(this)'>"+opitemsHtml+"</select></div>");
            }
        },

        error:function(data)
        {

        }

    });

}


//添加新功能
function addFunc(obj){

    var modal = $(obj).closest(".modal");
    //$("#adduser_win").find("")
    var funame = $.trim(modal.find(".funcname").val());
    var fuURL = modal.find(".funcurl").val();
    var sort = modal.find(".sort").val();
    var isShow = modal.find("input[name='addisshowrad']:checked").val();
    var isCheck = modal.find("input[name='addischeckrad']:checked").val();
    var fatherfuid = $("#fatherfuid").val();

    if( funame === "" ){
        modal.find(".modal-footer .error-tip").css("color","#ff0000").text("请输入功能名称！");
        return false;
    }

    if( parseInt(sort) < 0 ){
        modal.find(".modal-footer .error-tip").css("color","#ff0000").text("排序数字要大于等于零！");
        return false;
    }
    modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled

    $.ajax({
        type: "POST",
        url: "/sysmanage/addfunc",
        data:{fatherfuid:fatherfuid,funame:funame,fuURL:fuURL,isShow:isShow,isCheck:isCheck,sort:sort},
        dataType:"json",
        beforeSend:function(){

        },
        success: function(data)
        {
            modal.find(".modal-footer .error-tip").css("color",data.color).text(data.message);
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            if ( "ok" === data.status ){
                loadfuncWithRelay(function(){
                    window.location.reload();
                });
            }
        },
        error:function(data)
        {
            modal.find(".modal-footer .error-tip").css("color","red").text("系统出错，联系开发人员！");
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
        }
    });
}

//修改功能
function  updateFunc(obj){
    
    var modal = $(obj).closest(".modal");
    var fuid = modal.find(".fuid").val();
    var funame = $.trim(modal.find(".funcname").val());
    var fuURL = modal.find(".funcurl").val();
    var isShow = modal.find("input[name='udisshowrad']:checked").val();
    var isCheck = modal.find("input[name='udischeckrad']:checked").val();
    var sort = modal.find(".sort").val();
    var fatherfuid = $("#fatherfuid").val();
    
    if(funame === ""){
        modal.find(".modal-footer .error-tip").css("color","#ff0000").text("请输入功能名称！");
        return false;
    }

    if( parseInt(sort) < 0 ){
        modal.find(".modal-footer .error-tip").css("color","#ff0000").text("排序数字要大于等于零！");
        return false;
    }
    modal.find(".btn-primary").attr("disabled","true");  //确定按钮disabled

    $.ajax({
        type: "POST",
        url: "/sysmanage/modifyfuncs",
        data:{fuid:fuid,fatherfuid:fatherfuid,funame:funame,fuURL:fuURL,isShow:isShow,isCheck:isCheck,sort:sort},
        dataType:"json",
        beforeSend:function(){

        },
        success: function(data)
        {
            modal.find(".modal-footer .error-tip").css("color",data.color).text(data.message);
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
            if (data.status=="ok"){
                loadfuncWithRelay(function(){
                    window.location.reload();
                });
            }

        },

        error:function(data)
        {
            modal.find(".modal-footer .error-tip").css("color","red").text("系统出错，联系开发人员！");
            modal.find(".btn-primary").removeAttr("disabled");  //确定按钮enabled
        }

    });
}

//删除功能
function deleteFunc(fuid){
    if(confirm("您确定要删除此功能及其子功能吗？")){
        $.ajax({
            type: "POST",
            url: "/sysmanage/deletefunc",
            data:{fuid:fuid},
            dataType:"json",
            beforeSend:function(){

            },
            success: function(data)
            {
                alert(data.message);
                if (data.status=="ok"){
                    table.ajax.reload(null,false);
                }

            },

            error:function(data)
            {

            }

        });
    }
}

/**
 * 修改配置参数
 * @param {type} obj
 * @returns {undefined}
 */
function updateParameterconf(obj)
{
    if(confirm("确定修改参数信息吗？") )
    {
        var modal = $(obj).closest(".form-horizontal");
        var error_tip = modal.find(".box-footer .error-tip");
        error_tip.text("");
        error_tip.show();

        var downmessratio = modal.find(".downmessratio").val();
        var downtrueratio = modal.find(".downtrueratio").val();
        var onemeshTime = modal.find(".onemeshTime").val();
        var friedFishTime = modal.find(".friedFishTime").attr("data-data");
        var downmessbase = modal.find(".downmessbase").val();
        var downtruebase = modal.find(".downtruebase").val();
        var minspacetime = modal.find(".minspacetime").val();
        var maxspacetime = modal.find(".maxspacetime").val();
        
        if( $.trim(downmessratio).length<1 || !verifyFN(downmessratio))
        {
            error_tip.css("color","red").text("乱口下顿时间系数必须为大于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        
        if( $.trim(downtrueratio).length<1 || !verifyFN(downtrueratio))
        {
            error_tip.css("color","red").text("顿口下顿时间系数必须为大于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        
        if( $.trim(onemeshTime).length<1 || !verifyFN(onemeshTime))
        {
            error_tip.css("color","red").text("上浮一目的所需的时间必须为大于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        
        if( $.trim(downmessbase).length<1 || !verifyFloatORInt(downmessbase))
        {
            error_tip.css("color","red").text("乱口下顿时间基数必须为大于等于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        
        if( $.trim(downtruebase).length<1 || !verifyFloatORInt(downtruebase))
        {
            error_tip.css("color","red").text("顿口下顿时间基数必须为大于等于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        if( $.trim(minspacetime).length<1 || !verifyFloatORInt(minspacetime))
        {
            error_tip.css("color","red").text("乱口间隔时间最小值必须为大于等于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        
        if( $.trim(maxspacetime).length<1 || !verifyFloatORInt(maxspacetime))
        {
            error_tip.css("color","red").text("乱口间隔时间最大值必须为大于等于零的数字");
            loadfuncWithRelay(function(){error_tip.hide();},3000);
            return;
        }
        
        $.ajax({
            url:"/sysmanage/parameterconf",
            type:"POST",
            data:{
                modify:"modify",
                downmessratio:downmessratio, 
                downtrueratio:downtrueratio,
                onemeshTime:onemeshTime,
                friedFishTime:friedFishTime,
                downmessbase:downmessbase,
                downtruebase:downtruebase,
                minspacetime:minspacetime,
                maxspacetime:maxspacetime
            },
            dataType:"json",
            success:function(data){
                error_tip.css("color",data.color).text(data.message);
                window.location.reload();
            },
            error:function(data){
                error_tip.css("color","#ff0000").text("修改失败，您可能没有该权限！");
            }
        });   
    }
}

/**
 * 保存鱼重与溜鱼时间关系 
 * @param {type} obj
 * @returns {undefined}
 */
function savefriedFishTimeData(obj,id)
{
    if( confirm("确定修改么，修改后以最终在页面保存参数生效！") )
    {
        var modal = $(obj).closest(".modal");
        var error_tip = modal.find(".modal-footer .error-tip");
        var friedFishTimeDatas = modal.find(".title_ahead").find(".form-group");
        var friedFishTimeData = ""; 
        var flag = true;
        
        friedFishTimeDatas.each(function(index){
            var key = $(this).find(".key").val();
            var value = $(this).find(".value").val();
            if( key.length<1 || !verifyFN(key) )
            {
                error_tip.css("color","red").text("鱼重必须为大于零的数字");
                $(this).find(".key").focus();
                return flag=false;
            }
            if( value.length<1 || !verifyFN(value) )
            {
                error_tip.css("color","red").text("时间必须为大于零的数字");
                $(this).find(".value").focus();
                return flag=false;
            }
            if( index === friedFishTimeDatas.length-1 )
            {
                friedFishTimeData +="["+key+","+value+"]";
            }
            else
            {
                friedFishTimeData +="["+key+","+value+"],";
            }
            
        });
        if( flag && $("#"+id) !== undefined)
        {
            friedFishTimeData = "["+friedFishTimeData+"]";
            $("#"+id).attr("data-data",friedFishTimeData);  
            error_tip.css("color","green").text("已修改，请记得到页面保存");
            closeModalWithDelay(modal.attr("id"));
        }
        else 
        {
            error_tip.css("color","green").text("修改出错，请联系开发人员");
        }
    }
}