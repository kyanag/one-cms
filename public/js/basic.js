$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//bootbox 初始化
bootbox.addLocale("zh", {
    OK:'OK',
    CANCEL:'取消',
    CONFIRM:'确认'
});
bootbox.setDefaults({
    size: "small",
    centerVertical:true,
    scrollable:true,
    locale:"zh"
});


$(document).on("click", 'nav a[href="#"]', function (e) {
    e.preventDefault();
});

//header上的按钮
(function () {
    //菜单按钮
    var leftPanel = $('aside');
    var body = $('body');
    var menuToggleBtn = $('header .toggleMenu_btn');
    menuToggleBtn.on('click', function () {
        body.removeClass('minified');
        if (parseInt(leftPanel.css('left')) === 0) {
            leftPanel.css('left', 220);
            menuToggleBtn.addClass('active');
        } else {
            leftPanel.css('left', 0);
            menuToggleBtn.removeClass('active');
        }
    });
    $(window).on('resize', function () {
        if ($(window).width() >= 768) {
            leftPanel.css('left', 0);
            menuToggleBtn.removeClass('active');
        } else {
            body.removeClass('minified');
        }
    });
})();

//主导航
(function () {
    var $nav = $('aside nav');

    var invoke_nav = function () {
        var $a = $nav.find('a');
        $a.each(function () {
            var $btn = $(this);
            var $parent_li = $btn.parent();
            var $ul = $btn.next('ul');
            var $i = $btn.find('b i');
            if ($ul.length >= 1) {
                $btn.on('click', function () {
                    var ul_orgH = $ul.innerHeight();
                    if (!$parent_li.hasClass('open')) {
                        $parent_li.addClass('open');
                        $ul.css({'height': 0}).css('display', 'block');
                        $i.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                        $ul.animate({"height": ul_orgH}, {
                                queue: false, duration: 200, complete: function () {
                                    $ul.css('height', 'auto');
                                }
                            }
                        );
                    } else {
                        $parent_li.removeClass('open');
                        $i.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                        $ul.animate({"height": 0}, {
                                queue: false, duration: 200, complete: function () {
                                    $ul.css({'height': "auto"}).css('display', 'none');
                                }
                            }
                        );
                    }

                    $others_li = $btn.parent().siblings('.open');
                    $others_li.each(function () {
                        var $parent_li = $(this);
                        var $btn = $parent_li.find('a:first');
                        var $ul = $btn.next('ul');
                        var $i = $btn.find('b i');
                        $parent_li.removeClass('open');
                        $i.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                        $ul.animate({"height": 0}, {
                                queue: false, duration: 200, complete: function () {
                                    $ul.css({'height': "auto"}).css('display', 'none');
                                }
                            }
                        );
                    });
                });
            }
        });
    };

    invoke_nav();

    //导航下面的收起按钮
    var minifyBtn = $('aside .minifyBtn');
    var $body = $('body');
    minifyBtn.on('click', function () {
        $('aside nav li.open').each(function () {
            var $parent_li = $(this);
            var $btn = $parent_li.find('a:first');
            var $ul = $btn.next('ul');
            var $i = $btn.find('b i');
            $parent_li.removeClass('open');
            $i.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
            $ul.css({'height': "auto"}).css('display', 'none');
        });
        if (!$body.hasClass('minified')) {
            $body.addClass('minified');
            $(this).find('i').addClass('fa-flip-horizontal');
        } else {
            $body.removeClass('minified');
            $(this).find('i').removeClass('fa-flip-horizontal');
        }
    });
})();

//ajax内容弹出框
(function () {
    var $modal_ajax_content = $("#modal_ajax_content");
    $(document).on('click', '.J_ajax_content_modal', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if (typeof $btn.attr('data-href') !== 'undefined') {
            $.ajax({
                type: 'get',
                url: $btn.attr('data-href'),
                cache: false,
                data: '',
                dataType: 'html',
                beforeSend: function () {
                },
                success: function (returnData) {
                    $modal_ajax_content.find('.modal-content').html(returnData);
                    $modal_ajax_content.modal('show');
                },
                error: function () {
                    alert("未找到模板");
                }
            });
        } else {
            console.log("请配置'data-href'属性");
        }
    });
})();

//确认弹出框
(function () {
    var target = '';
    var type = '';
    var data = {};
    $(document).on('click', '.J_confirm_modal', function (e) {
        console.log(e);
        e.preventDefault();
        var btn = $(this);
        var tip = typeof btn.attr('data-tip') !== 'undefined' ? btn.attr('data-tip') : '确认吗？';
        target = typeof btn.attr('data-target') !== 'undefined' ? btn.attr('data-target') : '';
        type = typeof btn.attr('data-type') !== 'undefined' ? btn.attr('data-type') : 'get';

        var data = {};
        if(type.toUpperCase() !== "POST" || type.toUpperCase() !== "GET"){
            data = {
                '_method': `${type.toLowerCase()}`
            };
            type = "post"
        }
        bootbox.confirm(tip, (result) => {
            if(result){
                $.ajax({
                    type: type,
                    url: btn.attr('href'),
                    cache: false,
                    data: data,
                    dataType: 'json',
                    success: function (returnVal) {
                        bootbox.alert(returnVal.msg, () => {
                            window.location.href = returnVal.jump;
                        })
                    },
                    error: function () {
                        console.log(response);
                    }
                });
            }
        })
    });
})();

//J_ajaxSubmitBtn绑定事件
(function () {
    $(document).on('click', '.J_ajaxSubmitBtn', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if ($btn.hasClass('subBtn_unable')) {
            return;
        }
        $btn.addClass('subBtn_unable');
        var $from = $btn.parents('form');
        new AjaxForm($from, {
            type: $from.attr("method"),  //提交方式
            url: $from.attr("action"),  //提交地址
            $subBtn: $from.find(".J_ajaxSubmitBtn"),  //提交按钮
            sendingText: typeof $from.attr("data-sendingText") !== 'undefined' ? $from.attr("data-sendingText") : '提交中...',  //提交中的按钮文字
            useDefaultCallBack: $from.attr("data-useDefaultCallBack") !== 'off', //是否调用默认回调函数(只要值不为'off'都调用)
            callBack: typeof $from.attr("data-callBack") !== 'undefined' ? eval('(' + $from.attr("data-callBack") + ')') : false,  //自定义回调函数
            validate: typeof $from.attr("data-validate") !== 'undefined' ? eval('(' + $from.attr("data-validate") + ')') : false  //最终验证函数
        });
    });
})();

//树形菜单表格
(function () {
    $(document).on('click', '.J_tree_table .J_pull_btn', function () {
        var $btn = $(this);
        if ($btn.hasClass('pull_down')) {
            $btn.removeClass('pull_down').addClass('pull_up');
            /*var $tr = $btn.parent();
             while ($tr[0].nodeName.toLowerCase() !== 'tr') {
             $tr = $tr.parent();
             }*/
            var $tr = $btn.parents('tr');
            $tr.siblings().css('display', 'none');
        } else if ($btn.hasClass('pull_up')) {
            $btn.removeClass('pull_up').addClass('pull_down');
            var $tr2 = $btn.parents('tr');
            $tr2.siblings().css('display', 'table-row');
        }
    });
    $(document).on('click', '.J_tree_table_all_open', function () {
        var $btn = $(this);
        var $targetTable = $($btn.attr('data-target'));
        if ($targetTable.length >= 1) {
            var $all_J_pull_btn = $targetTable.find('.J_pull_btn');
            $all_J_pull_btn.removeClass('pull_up').addClass('pull_down');
            var $all_tr = $targetTable.find('tr');
            $all_tr.css('display', 'table-row');
        }
    });
    $(document).on('click', '.J_tree_table_all_close', function () {
        var $btn = $(this);
        var $targetTable = $($btn.attr('data-target'));
        if ($targetTable.length >= 1) {
            var $all_J_pull_btn = $targetTable.find('.J_pull_btn');
            $all_J_pull_btn.each(function () {
                var $btn = $(this);
                $btn.removeClass('pull_down').addClass('pull_up');
                var $tr = $btn.parents('tr');
                $tr.siblings().css('display', 'none');
            });
        }
    });
})();

//角色权限面板
(function () {
    $(document).on('change', '.role_permission .control-label input[type=checkbox]', function () {
        var $role_permission = $(this).parents('.role_permission');
        if ($(this).prop("checked")) {
            $role_permission.find('input[type=checkbox]').each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $role_permission.find('input[type=checkbox]').each(function () {
                $(this).prop("checked", false);
            });
        }
    });

    $(document).on('change', '.role_permission .panel-heading input[type=checkbox]', function () {
        var $panel = $(this).parents('.panel');
        var $bigCheck = $panel.parents('.role_permission').find('.control-label input[type=checkbox]');
        if ($(this).prop("checked")) {
            $panel.find('input[type=checkbox]').each(function () {
                $(this).prop("checked", true);
            });
            $bigCheck.prop("checked", true);
        } else {
            $panel.find('input[type=checkbox]').each(function () {
                $(this).prop("checked", false);
            });
        }
    });

    $(document).on('change', '.role_permission .panel-body input[type=checkbox]', function () {
        var $panel = $(this).parents('.panel');
        var $bigCheck = $panel.parents('.role_permission').find('.control-label input[type=checkbox]');
        var $midCheck = $panel.find('.panel-heading input[type=checkbox]');
        if ($(this).prop("checked")) {
            $midCheck.prop("checked", true);
            $bigCheck.prop("checked", true);
        }
    });
})();