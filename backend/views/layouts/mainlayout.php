<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\PageAsset;
use yii\helpers\Html;
//use yii\widgets\Breadcrumbs;
//use common\widgets\Alert;

PageAsset::register($this);
$this->title = Yii::$app->params["SYSNAME"];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title> 
    <?php $this->head() ?>   
    
<!--    <link rel="stylesheet" href="/AdminLTE/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css"/>
    <link rel="stylesheet" href="/AdminLTE/dist/css/AdminLTE.min.css"/>
    <link rel="stylesheet" href="/AdminLTE/dist/css/skins/_all-skins.min.css"/>
    <link rel="stylesheet" href="/css/common.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.4.0/sweetalert2.min.css"/>
    
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
    <script src="/AdminLTE/dist/js/app.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.4.0/sweetalert2.min.js"></script>
    <script src="/js/common.js"></script>-->
    
</head>
<body class="hold-transition sidebar-mini skin-blue">
<?php $this->beginBody() ?>

<div class="wrapper">
    <?php echo $this->render("UI/header");?>
    <?php echo $this->render("UI/left");?>
    <div class="content-wrapper" style="min-height: 916px;">
        <?=$content?>
    </div>
    <?php echo $this->render("UI/footer");?>
    <?php echo $this->render("UI/right");?>
</div>
    
<!--修改密码弹框-->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" id="updatemypw_win">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">修改密码</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">新密码</label>
                            <div class="col-sm-10">
                                <input type="password" placeholder="请输入新密码" class="form-control up-passwd" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">确认密码</label>
                            <div class="col-sm-10">
                                <input type="password" placeholder="再次输入密码" class="form-control up-repasswd" value="" />
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <span class="error-tip margin-r-5"></span>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="updateMyPasswd(this)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    
$(function(){
    $("#updatemypw_win").on("show.bs.modal",function(event){
       //var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find("input").val("");
        modal.find(".error-tip").text("");
    });
});
    
 /**
 * 修改我的密码
 * @param {type} obj
 * @returns {undefined}
 */
function updateMyPasswd(obj)
{
    if( confirm("确定修改么！") )
    {
        var modal = $(obj).closest(".modal");
        var error_tip = modal.find(".error-tip");
        var pwd1 = $.trim(modal.find(".up-passwd").val());
        var pwd2 = $.trim(modal.find(".up-repasswd").val());
        
        if( pwd1.length < 4 )
        {
            error_tip.css("color","red").text("密码要大于等4个字符");
            return;
        }
        if( pwd1 !== pwd2 )
        {
            error_tip.css("color","red").text("两次输入密码不相同！");
            return;
        }
        $.ajax({
            url:"/index/resetpwd",
            type:"POST",
            data:{pwd1:pwd1,pwd2:pwd2},
            dataType:"json",
            success:function(data){
                error_tip.css("color",data.color).text(data.message);
                if( data.status === "ok" )
                {
                    loadfuncWithRelay(function(){modal.modal("hide");},1500);
                }
            },
            error:function(data)
            {
                error_tip.css("color","red").text("出错了，联系系统提供者！");
            }
        });
    }
}
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
