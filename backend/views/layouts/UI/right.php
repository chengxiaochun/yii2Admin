<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    var my_skins = [
        "skin-blue",
        "skin-black",
        "skin-red",
        "skin-yellow",
        "skin-purple",
        "skin-green",
        "skin-blue-light",
        "skin-black-light",
        "skin-red-light",
        "skin-yellow-light",
        "skin-purple-light",
        "skin-green-light"
      ];
    $(function(){
        setup();
    });
    /**
     * Replaces the old skin with the new skin
     * @param String cls the new skin class
     * @returns Boolean false to prevent link's default action
     */
    function change_skin(cls) {
        $.each(my_skins, function (i) {
            $("body").removeClass(my_skins[i]);
        });
        $("body").addClass(cls);
        store('skin', cls);
        return false;
    }

    /**
     * Retrieve default settings and apply them to the template
     *
     * @returns void
     */
    function setup() {
        var tmp = get('skin');

        if (tmp && $.inArray(tmp, my_skins))
            change_skin(tmp);
        //Add the change skin listener
        $("[data-skin]").on('click', function (e) {
            if ($(this).hasClass('knob'))
                return;
            e.preventDefault();
            change_skin($(this).data('skin'));
        });
    }
</script>
<aside class="control-sidebar control-sidebar-dark">
    <h4 class="control-sidebar-heading">设置皮肤</h4>
    <ul class="list-unstyled clearfix">
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                    <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin">Blue</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                    <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
                    <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin">Black</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                    <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin">Purple</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                    <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin">Green</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                    <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin">Red</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                    <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin">Yellow</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                    <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                    <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
                    <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                    <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                    <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                    <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
        </li>
        <li style="float:left; width: 33.33333%; padding: 5px;">
            <a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                    <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                </div>
            </a>
            <p class="text-center no-margin" style="font-size: 12px;">Yellow Light</p>
        </li>
    </ul>
<!-- /.tab-pane -->
</aside>
