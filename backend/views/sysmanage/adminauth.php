<link rel="stylesheet" href="/plugins/powertree/css/powertree.css">
<script src="/plugins/powertree/js/powertree.js"></script>
<script src="/js/page/powermanage.js"></script>
<!-- 头部标题-->
<section class="content-header">
    <h1>
        系统管理
        <small>管理员授权</small>
    </h1>
</section>

<!-- 主体内容 -->
<section class="content">
    <!-- 当前选中的用户组ugid -->
    <input type="hidden" value="0" id="thisugid"/>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">管理员分组</h3>
                </div>
                <div class="box-body">
                    <ul class="treeview-box nocb withcurr">
                        <?php
                            $data = common\components\Common_class::getUsegroup();
                            common\components\Common_class::getTreeUsergroupWithoutBtns($data);
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="display: none" id="funcsWin">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">功能列表</h3>
                </div>
                <div class="box-body">
                    <ul class="treeview-box">
                        <?php
                            $data = \common\components\Common_class::getfuncs(null,true);
                            \common\components\Common_class::getTreeFuncsWithoutBtns($data);
                        ?>
                    </ul>
                </div>
                <div class="box-footer">
                    <button class="btn btn-info pull-right" type="button" onclick="savePower()">保存</button>
                    <button class="btn btn-default pull-right margin-r-5" type="button"  onclick="cancelPower()">取消</button>
                    <span class="error-tip pull-right" style="line-height: 34px; margin-right: 10px;"></span>
                </div>
            </div>
        </div>
    </div>
</section>

