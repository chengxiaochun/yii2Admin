<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'AdminLTE/bootstrap/css/bootstrap.min.css',
        "//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css",
        '//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css',
        "AdminLTE/dist/css/AdminLTE.min.css",
        'AdminLTE/dist/css/skins/_all-skins.min.css',
        "css/common.css",
        "node_modules/sweetalert2/dist/sweetalert2.min.css",
        //"https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.4.0/sweetalert2.min.css",
    ];
    public $js = [
//        "//cdn.bootcss.com/jquery/2.2.4/jquery.min.js",
        "AdminLTE/bootstrap/js/bootstrap.min.js",
        "AdminLTE/dist/js/app.min.js",
        //"https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.4.0/sweetalert2.min.js",
        "node_modules/sweetalert2/dist/sweetalert2.min.js",
        "js/common.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
