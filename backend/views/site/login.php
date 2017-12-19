<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::$app->params["SYSNAME"];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <?=$this->title?>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">登录</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username',['template' => '<div class="has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>{error}</div>'])
                    ->label(FALSE)
                    ->textInput(['autofocus' => true,"placeholder"=>"用户名"])
                    ?>
                <?= $form->field($model, 'password',['template' => '<div class="has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}</div>'])
                    ->passwordInput(["placeholder"=>"密码"])
                    ->label(FALSE) ?>
            
                <?=$form->field($model,'verifyCode')->widget(Captcha::className(),[
                      'captchaAction'=>'site/captcha',
                      'options'=>[
                          'placeholder'=>'输入验证码',
                          "class"=>"form-control"
                      ],
                      'template'=>'<div class="row"><div class="col-xs-6">{input}</div><div class="col-xs-6">{image}</div></div>',
                  ])->label(false)?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group" style="overflow: hidden">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>
                </div>
<!--                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                      Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                      Google+</a>
                </div>
                <a href="#" class="pull-right">忘记密码？</a>-->
            <?php ActiveForm::end(); ?>
    </div>
</div>



