<?php
return [
    'adminEmail' => 'admin@example.com',
    //datatable插件源
    'datatablesrc' =>["css"=>"//cdn.bootcss.com/datatables/1.10.13/css/dataTables.bootstrap.css",
        "datatables"=>"//cdn.bootcss.com/datatables/1.10.13/js/jquery.dataTables.min.js",
        "bootstrap"=>"//cdn.bootcss.com/datatables/1.10.13/js/dataTables.bootstrap.min.js"],
    "access_url_filter"=>["/index/index","/sysmanage/getfatherfuid","/sysmanage/funcsgroup",
        "/index/resetpwd","/admin/admingroup","/sysmanage/getfunsbyugid"], //不需要检测权限url
];
