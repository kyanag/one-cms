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

//确认弹出框
(function () {
    var target = '';
    var type = '';
    var data = {};
    $(document).on('click', '.J_confirm_modal', function (e) {
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