$('.next_li').onclick = function (){
    alert('sb');
}
// 窗口改变 左侧主导航开关
$(window).resize(function () {
    if (window.innerWidth <= 1025) {
        $(".sidebar").addClass("w50");
        $(".indexContent, .sidebar_2").css("margin-left", "50px");
        if ($(".sidebar_2").css("width") == "0px") {
            $(".mainWrap").css("margin-left", "50px");
        } else {
            $(".mainWrap").css("margin-left", "200px");
        }
        $(".right_headerIcon").addClass("on");
        $(".right_headerNav").addClass("disNone");

    } else {
        $(".right_headerIcon").removeClass("on");
        $(".right_headerNav").removeClass("disNone");
        $(".indexContent").css("margin-left", "150px");
        $(".sidebar").removeClass("w50");
        $(".sidebar_2").css("margin-left", "150px");
        $(".mainWrap").css("margin-left", "300px");
    }
});

// 窗口宽度小于1025时 左侧主导航闭合
$(function () {
    if (window.innerWidth <= 1025) {
        $(".right_headerIcon").addClass("on");
        $(".right_headerNav").addClass("disNone");

        $(".sidebar").addClass("w50");
        if ($(".sidebar").hasClass("w50")) {
            $(".indexContent, .sidebar_2").css("margin-left", "50px");
            $(".mainWrap").css("margin-left", "200px");
        }
    } else {
        $(".right_headerIcon").removeClass("on");
        $(".right_headerNav").removeClass("disNone");
        $(".sidebar_2").css("margin-left", "150px");
        $(".mainWrap").css("margin-left", "300px");
    }
});

// 左侧主导航 下拉菜单
$(".list_title").click(function () {
    $(this).children(".fa-caret-down").toggleClass("rotates");
    $(this).next(".secondNav").slideToggle(200);
});

// 左侧主导航 点击 切换开关效果
$(".sidebarIcon").click(function () {
    var $this = $(this);
    $this.toggleClass("rotateNone");
    $this.parents(".sidebar").toggleClass("w50");

    if ($this.parents(".sidebar").hasClass("w50")) {
        $(".indexContent, .sidebar_2").css("margin-left", "50px");
        if ($(".sidebar_2").css("width") == "0px") {
            $(".mainWrap").css("margin-left", "50px");
        } else {
            $(".mainWrap").css("margin-left", "200px");
        }
    } else {
        $(".indexContent, .sidebar_2").css("margin-left", "150px");
        if ($(".sidebar_2").css("width") == "0px") {
            $(".mainWrap").css("margin-left", "200px");
        } else {
            $(".mainWrap").css("margin-left", "300px");
        }
    }
});

// 顶部右侧导航
$(".right_headerIcon").click(function () {
    var $this = $(this);
    $this.children(".fa-th-large").toggleClass("fa-th");
    $this.next(".right_headerNav").toggleClass("disNone");
});

// 中间导航
$(".switchIcon").click(function () {
    var $this = $(this);
    $this.parent(".sidebar_2").css("width", "0");
    $this.hide();
    $this.siblings(".switchIcon2").show();
    if ($(".sidebar").hasClass("w50")) {
        $(".mainWrap").css("margin-left", "50px");
    } else {
        $(".mainWrap").css("margin-left", "150px");
    }
});

$(".switchIcon2").click(function () {
    var $this = $(this);
    $this.parent(".sidebar_2").css("width", "150px");
    $this.hide();
    $this.siblings(".switchIcon").show();
    if ($(".sidebar").hasClass("w50")) {
        $(".mainWrap").css("margin-left", "200px");
    } else {
        $(".mainWrap").css("margin-left", "300px");
    }
});

// 小黑屋 删除
$(function () {
    $(".removeBtn").click(function () {
        $(this).parents("tr").remove();
    });
})

// 弹出层
$(".createNew").click(function () {
    $(".popUp_layer").show().animate({
        opacity: 1
    }, 200);
});
$("#close, #cancel_btn, #sure_btn").click(function () {
    $(".popUp_layer").hide().animate({
        opacity: 0
    }, 200);
});

// 判断分页按钮是否失效
$(function () {
    if ($('.li1').hasClass("active")) {
        $('.previous_li').addClass("disabled");
        if ($('.page li').length <= 3) {
            $(".next_li").addClass("disabled");
        } else {
            $(".next_li").removeClass("disabled");
        }
    } else {
        $('.previous_li').removeClass("disabled");
    }
});

jQuery('.tabBox').slide({
    trigger: "click"
});

$('#backbtn').bind('click', function(){
    window.history.back(-1);
})

/** 旧版的内容
// 全选
function checkAll() {
    var checks = document.getElementsByName("check");
    var allcheck = document.getElementsByClassName("allCheck");

    if (allcheck[0].checked) {
        for (var i = 0; i < checks.length; i++) {
            checks[i].checked = true;
        }
    } else {
        for (var i = 0; i < checks.length; i++) {
            checks[i].checked = false;
        }
    }
}

// 删除
$(".delBtn").click(function () {
    $("input[name='check']:checked").each(function () {
        $(this).parents("tr").remove();

        var num = $(".tables tbody tr").length - 2; //显示几条
        $("#num").html(num);
        if (num == 0)
            $("#tableTips").show();
        else
            $("#tableTips").hide();
    });
});

// 共N条
$(function () {
    var num = $(".tables tbody tr").length - 2;
    $("#num").html(num);

    if (num == 0)
        $("#tableTips").show();
    else
        $("#tableTips").hide();
})

旧版的内容*/