$(function () {

    //折叠效果
    $(".treeview-box li .view-item i").click(function () {
        if ($(this).hasClass("fa-plus-square")) {
            $(this).removeClass("fa-plus-square").addClass("fa-minus-square");
            $(this).closest(".view-item").next("ul").show();
        } else {
            $(this).removeClass("fa-minus-square").addClass("fa-plus-square");
            $(this).closest(".view-item").next("ul").hide();
        }
    })

    //全选及反选
    $(".treeview-box li .checkbox input[type='checkbox']").click(function(){       
        if($(this).closest(".view-item").next().is("ul")){
            var $subBox = $(this).closest(".view-item").next("ul").find(".checkbox input[type='checkbox']");
            var $subCheckedBox = $(this).closest(".view-item").next("ul").find(".checkbox input[type='checkbox']:checked");
            $subBox.prop("checked", this.checked);
        }
        //返选时没有子级
        if( !this.checked )
        {
            return;
        }
        $(this).parents("ul").each(function(){
            var $subBoxLength = $(this).find(".checkbox input[type='checkbox']").length;
            var $subCheckedBoxLength = $(this).find(".checkbox input[type='checkbox']:checked").length;
            //只要有选中则父级选中
            $(this).siblings(".view-item").find(".checkbox input[type='checkbox']").prop("checked", $subCheckedBoxLength>0 ? true : false);
            //有一个未选则父级不选
            //$(this).siblings(".view-item").find(".checkbox input[type='checkbox']").prop("checked", $subBoxLength == $subCheckedBoxLength ? true : false);

        })
    })

    //点击选中（有withcurr类）
    $(".withcurr .checkbox").click(function () {
        $(".withcurr .checkbox").css("backgroundColor","#3c8dbc");
        $(this).css("backgroundColor","#db8b0b")
    })

//修改
    $(".handle-btns .edit-btn").click(function () {
        var val = $(this).closest(".view-item").find(".checkbox label .val").text();
        $(this).closest(".view-item").find(".checkbox label").hide();
        $(this).closest(".view-item").find(".checkbox .edit-txt").val(val).show();
        $(this).closest(".view-item").find(".editdel").hide().siblings(".savecancel").show();
    });

    //取消
    $(".handle-btns .cancel-btn").click(function () {
        $(this).closest(".view-item").find(".checkbox .edit-txt").hide();
        $(this).closest(".view-item").find(".checkbox label").show();
        $(this).closest(".view-item").find(".savecancel").hide().siblings(".editdel").show();
    });


})

