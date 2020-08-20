(function($){
    var createFile = function(delay){
        delay = 1000;

        var input = document.createElement("INPUT");
        input.setAttribute("type", "file");
        input.style.display = "none";

        setTimeout(function(){
            input.remove();
        }, delay);

        return input;
    };

    var defaultOptions = {
        namespace:"oneform-",
        onsuccess:null,
        onerror:null,
        url:null,
        datetimePicker:{
            locale: "zh",
            format: "Y-m-d"
        },
        uploader:{
            url:null,
            resize: false,
            chunked: true,
            chunkSize: 1024 * 1024 * 1,
            threads: 1,
        },
        ckeditor:{
            language: 'zh-cn'
        }
    };

    $.formerSetup = function(options){
        defaultOptions = $.extend(true, defaultOptions, options);
    };

    $.fn.former = function (options) {
        options = $.extend(defaultOptions, options);
        var namespace = options.namespace;

        //日期时间选择
        $(this).find(`.${namespace}datetime`).each(function () {
            var format = $(this).data("format") || options.datetimePicker.format;
            if(format === "date"){
                format = "yyyy-MM-DD";
            }else if(format === "time"){
                format = "HH:MM";
            }else{
                format = "yyyy-MM-DD";
            }

            let pickerOptions = $.extend({}, options.datetimePicker, {format});
            flatpickr(this, pickerOptions);
        });

        $(this).find(`.${namespace}range`).each(function(){
            var min = parseFloat($(this).attr("min") || 0);
            var max = parseFloat($(this).attr("max") || 100);
            var that = $(this).parent().parent().find(".custom-range-input");

            $(this).change(() => {
                $(that).val($(this).val());
            });

            $(that).change(() => {
                var value = parseFloat($(that).val());
                if(value < min){
                    value = min;
                }
                if(value > max){
                    value = max;
                }
                $(this).val(value);
            });
        });

        //ajax文件上传
        $(this).find(`.${namespace}ajaxfile`).each(function(){
            var btn = $(this).parent().find(".ajax-file-btn");
            $(btn).click(() => {
                console.log($(this).data());
                var upOptions = $.extend(options.uploader ,$(this).data());

                var uploader = WebUploader.create(upOptions);
                uploader.on("uploadSuccess", (file, response) => {
                    $(this).val(response.url);

                    $(this).popover({
                        content:"上传成功!",
                        delay: {
                            "show": 500,
                            "hide": 100
                        },
                        placement: "top",
                    });
                });

                var file = createFile();
                $(file).change(function(){
                    var files = $(this).prop("files");
                    for(let i = 0; i < files.length; i++){
                        uploader.addFile(files.item(i));
                    }
                    uploader.upload();
                });
                $(file).click();
            });
        });

        //selectize选择
        $(this).find(`.${namespace}selectize`).each(function(){
            $(this).selectize({
                load: function(query, callback) {
                    console.log(query);
                }
            });
        });

        //selectize选择
        $(this).find(`.${namespace}ckeditor`).each(function(){
            var editorOptions = $.extend(options.ckeditor, $(this).data());

            ClassicEditor.create( this, editorOptions)
                .then( editor => {
                    console.log( editor );
                } )
                .catch( error => {
                    console.error( error );
                } );
        });
    };
})(jQuery);