$(function(){
    menuCurrent();
});

//刷新验证码
function refeshcode(obj) {
    $(obj).attr("src", "/user/refreshcode?" + Math.round(Math.random() * 100) + 85);
}


//延迟1s关闭弹框
function closeModalWithDelay(winid){
    setTimeout("$('#"+winid+"').modal('hide')",1000);
}

//延迟加载
function loadfuncWithRelay(funcstr,delaytime){
    setTimeout(funcstr,parseInt(delaytime)?parseInt(delaytime):2000);   
}


//验证手机
function checkPhone(val) {

    var match = /^(((13|15|18|14)+[0-9]{1}))+\d{8}$/;
    if (!match.test(val)) {
        return false;
    }else{
        return true;
    }
}

//验证邮箱
function checkEmail(val) {

    var match = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
    if (!match.test(val)) {
        return false;
    }else{
        return true;
    }
}

//用户名格式验证(5-16位，可由英文、数字及"_"、"."、"-"符号组成)
function checkUser(val) {

    var match = /[a-zA-Z0-9_\.-]{4,15}$/;
    if (!match.test(val)) {
        return false;
    }else{
        return true;
    }
}


//密码格式验证(5-16位，可由英文、数字及符号组成)
function checkPwd(val) {

    var match = /[a-zA-Z0-9~!@#$%-&*_]{5,16}$/;
    if (!match.test(val)) {
        return false;
    }else{
        return true;
    }
}

//验证是否为非零的正整数
function  verifyN(val){
    var zz_val = /^\+?[1-9][0-9]*$/;
    if(zz_val.test(val)){
        return true;
    }else{
        return false;
    }
}

//验证是否为0或正整数
function  verifyNZ(val){
    var zz_val = /^\+?[1-9][0-9]*$/;
    if(zz_val.test(val)||val=="0"){
        return true;
    }else{
        return false;
    }
}

//验证是否为大于零小数或正整数
function  verifyFN(val){
    var zz_val = /^[0-9]+([.][0-9]+){0,1}$/;
    if( zz_val.test(val) && parseFloat(val)>0 ){
        return true;
    }else{
        return false;
    }
}

//验证是否为浮点数或整数
function  verifyFloatORInt(val){
    var zz_val = /^[0-9]+([.][0-9]+){0,1}$/;
    if(zz_val.test(val)){
        return true;
    }else{
        return false;
    }
}

/**
 * 时间戳转日期
 * @param ns 时间戳 只到秒
 * @returns {string}
 */
function   formatDate(ns)   {
    var now = new Date(parseInt(ns)*1000);
    var   year=now.getYear()+1900;
    var   month=(now.getMonth()+1)<10?'0'+(now.getMonth()+1):(now.getMonth()+1);
    var   date=now.getDate()<10?'0'+(now.getDate()):now.getDate();
    var   hour=now.getHours()<10? '0'+now.getHours():now.getHours();
    var   minute=now.getMinutes()<10?'0'+now.getMinutes():now.getMinutes();
    var   second=now.getSeconds()<10?'0'+now.getSeconds():now.getSeconds();
    return   year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second;
}

/**
 * 清空 输入框
 * @param obj
 */
function clearInput(obj)
{
    var _input = $(obj).prev("input");

    if( _input.val() != "" && _input.val() != null && _input.val() != undefined )
    {
        _input.val("");
        _input.change();
    }
}

//检查图片是否存在  
function CheckImgExists(imgurl) {  
    var ImgObj = new Image(); //判断图片是否存在  
    ImgObj.src = imgurl;  
    //没有图片，则返回-1  
    if (ImgObj.fileSize > 0 || (ImgObj.width > 0 && ImgObj.height > 0)) {  
        return true;
    } else {  
        return false;
    }  
} 

//左侧栏目选中
function menuCurrent(){
    var pathname = window.location.pathname;
    //var controname =
    $(".sidebar .sidebar-menu li").each(function(){
        var funurl = $(this).attr("data-url");
        if(pathname==funurl){
            $(this).parents("li").addClass("active");
            $(this).addClass("active");
            return false; //跳出each循环
        }
    })
}

/**
 * alert 弹框
 * @param {type} type_class   弹框类型class （alert-error:错误;alert-warning:警告;alert-success:成功）      
 * @param {type} message     显示内容
 * @returns {undefined}
 */
function commonAlert(type_class, message)
{
    if( $("#common_alert_win") )
    {
        var modal = $("#common_alert_win");
        var alert_div = modal.find(".alert");
        alert_div.removeClass("alert-error alert-warning alert-success");
        alert_div.addClass(type_class);
        modal.find(".message").text(message);
        switch(type_class)
        {
            case "alert-success": modal.find(".strong").text("成功！");break;
            case "alert-warning": modal.find(".strong").text("警告！");break;
            case "alert-error": modal.find(".strong").text("错误！");break;
            default:modal.find(".strong").text("成功！");break;
        }
        
        modal.modal("show");
    }
}

/**
 * Store a new settings in the browser
 *
 * @param String name Name of the setting
 * @param String val Value of the setting
 * @returns void
 */
function store(name, val) {
    if (typeof (Storage) !== "undefined") {
        localStorage.setItem(name, val);
    } else {
        window.alert('Please use a modern browser to properly view this template!');
    }
}

/**
 * Get a prestored setting
 *
 * @param String name Name of of the setting
 * @returns String The value of the setting | null
 */
function get(name) {
    if (typeof (Storage) !== "undefined") {
        return localStorage.getItem(name);
    } else {
        window.alert('Please use a modern browser to properly view this template!');
    }
}