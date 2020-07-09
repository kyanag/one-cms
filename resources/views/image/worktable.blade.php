
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="admin@sourcefree.com">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>简单抠图</title>

    <!-- Bootstrap core CSS -->
{{--    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="https://cdn.bootcdn.net/ajax/libs/bootswatch/4.5.0/cosmo/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.13.1/css/all.min.css" rel="stylesheet">
    <style>
        .head-back-color-btn{
            border: none;
        }
        .head-back-btn-white {
            background-color: #FFFFFF;
            color: #0c0c0c;
        }
        .head-back-btn-red {
            background-color: #FF0000;
            color: #0c0c0c;
        }
        .head-back-btn-blue {
            background-color: #00BFF3;
            color: #0c0c0c;
        }

        #file-select-btn input[type=file]{
            display: none;
        }
    </style>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">简单抠图</h5>
{{--    <nav class="my-2 my-md-0 mr-md-3">--}}
{{--        <a class="p-2 text-dark" href="#">Features</a>--}}
{{--        <a class="p-2 text-dark" href="#">Enterprise</a>--}}
{{--        <a class="p-2 text-dark" href="#">Support</a>--}}
{{--        <a class="p-2 text-dark" href="#">Pricing</a>--}}
{{--    </nav>--}}
</div>

<div class="container">
    <div class="card-deck row justify-content-md-center text-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">证件照换背景色</h4>
                </div>
                <div class="card-body bg-light">
                    <div class="pricing-header px-3 mx-auto text-center">
                        <p class="lead">1. 选择你的证件照</p>
                        <p class="lead">2. 选择颜色</p>
                        <p class="lead">3. 下载照片</p>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm pm-1" id="file-select-btn"><i class="fa fa-upload" aria-hidden="true"></i> 选择图片</button>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="image-face" class="d-flex mx-auto align-items-end pt-3">
                                <canvas id="image-canvas" class="m-auto"></canvas>
                            </div>
                        </div>
                        <div class="col-md-12 m-0 pt-3">
                            <div class="btn-group btn-group-sm pt-1" aria-label="背景色" id="actionbar-color">
                                <button type="button" class="btn btn-default ml-1">背景色</button>
                            </div>

                            <div class="btn-group btn-group-sm pt-1 ml-2" aria-label="裁剪" id="actionbar-size" style="display: none">
                                <button type="button" class="btn btn-default btn-sm">裁剪</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-block btn-primary mt-4" id="download">下载</button>
                    <button type="button" class="btn btn-sm btn-block btn-warning mt-2">赞赏</button>
                    <div class="btn-group btn-group-sm mt-2">
                        <button type="button" class="btn btn-sm btn-success mt-2">微信小程序</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <small class="d-block mb-3 text-muted">&copy; 2017-2020</small>
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Cool stuff</a></li>
                    <li><a class="text-muted" href="#">Random feature</a></li>
                    <li><a class="text-muted" href="#">Team feature</a></li>
                    <li><a class="text-muted" href="#">Stuff for developers</a></li>
                    <li><a class="text-muted" href="#">Another one</a></li>
                    <li><a class="text-muted" href="#">Last time</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Resource</a></li>
                    <li><a class="text-muted" href="#">Resource name</a></li>
                    <li><a class="text-muted" href="#">Another resource</a></li>
                    <li><a class="text-muted" href="#">Final resource</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>About</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Team</a></li>
                    <li><a class="text-muted" href="#">Locations</a></li>
                    <li><a class="text-muted" href="#">Privacy</a></li>
                    <li><a class="text-muted" href="#">Terms</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>

<script>
    var HeadMatting = function(options){
        const COLOR_RED = {rgb:"#FF0000", name: "红"};
        const COLOR_WHITE = {rgb:"#FFFFFF", name: "白"};;
        const COLOR_BLUE = {rgb:"#00BFF3", name: "蓝"};;

        const SIZE_1         = {width: 295, height: 413, name: "1寸"};
        const SIZE_2_LITTLE  = {width: 390, height: 567, name: "小2寸"};
        const SIZE_2         = {width: 413, height: 626, name: "2寸"};
        //const SIZE_SFZ       = {width: 260, height: 390, name: "身份证"};

        var activeColor = COLOR_RED;
        var activeSize = SIZE_1;
        var imageBlob;
        var canvasCtx;

        this.setImage = function(img){
            imageBlob = img;
            this.drawImage();
        };

        this.mockImage = function(){
            var svg = `
<svg width="${activeSize.width}" height="${activeSize.height}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${activeSize.width} ${activeSize.height}" preserveAspectRatio="none">
    <defs>
        <style type="text/css">#holder_158bd1d28ef text { fill:rgba(255,255,255,.75);font-weight:normal;font-family:Helvetica} </style>
    </defs>
    <g id="holder_158bd1d28ef"><rect width="${activeSize.width}" height="${activeSize.height}" fill="#777"></rect>
        <g>
        <text x="50%" y="45%" dy=".3em" text-anchor="middle" font-family="MSYH">点击 [选择图片]</text>
        <text x="50%" y="55%" dy=".3em" text-anchor="middle" font-family="MSYH"> 上传任意正面图</text>
        </g>
    </g>
</svg>`;
            var img = new Image();
            img.src = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svg)));//svg内容中可以有中文字符
            return img;
        };

        this.setColor = function (color) {
            activeColor = {rgb:color};
            this.drawImage();
        };

        this.init = function(){
            canvasCtx = document.querySelector("#image-canvas").getContext("2d");

            var sizes = [
                SIZE_1,
                SIZE_2_LITTLE,
                SIZE_2,
            ];
            var colors = [
                COLOR_WHITE,
                COLOR_RED,
                COLOR_BLUE,
            ];
            sizes.forEach( size => {
                var sizeBtn = `<button type="button" class="btn btn-outline-info matting-size" data-size="${size.width}*${size.height}">${size.name}</button>`
                $("#actionbar-size").append(sizeBtn);
            });

            colors.forEach( color => {
                var colorBtn = `<button type="button" class="btn btn-outline-primary matting-color" data-color="${color.rgb}">${color.name}</button>`;

                $("#actionbar-color").append(colorBtn);
            });
            this.registerEvents();

            //this.setSize(SIZE_1);
            this.drawImage();
        };

        this.registerEvents = function(){
            $("#file-select-btn").click(() => {
                this.showOpenDialog().then((file) => {
                    return this.uploadFile(file);
                }).then((response) => {
                    var blob = new Blob([response]);

                    this.setImage(blob);
                });
            });

            $(".matting-color").click((e) => {
                this.setColor($(e.target).data("color"));
            });
            $(".matting-size").click((e) => {
                var size = $(e.target).data("size");
                var [width, height] = size.split("*");

                this.setSize({width, height});

                $(".matting-size").each(function(){
                    $(this).removeClass("btn-info");
                    $(this).addClass("btn-outline-info");
                });

                $(this).addClass("btn-info");
                $(this).removeClass("btn-outline-info");
            });

            $("#download").click(() => {
                this.download();
            })
        };

        this.drawImage = function(){
            var image;
            if(imageBlob){
                image = new Image();
                image.src = URL.createObjectURL(imageBlob);
            }else{
                image = this.mockImage();
            }
            image.onload = () => {
                //清空画布
                $("#image-canvas")
                    .attr("width", image.width)
                    .attr("height", image.height);

                canvasCtx.fillStyle = activeColor.rgb;
                canvasCtx.fillRect(0, 0, image.width, image.height);

                canvasCtx.drawImage(image, 0, 0);
            };
            document.body.appendChild(image);
        };

        this.setSize = function (size) {
            console.log(size);
            activeSize = size;
            $("#image-face")
                .css("width", `${size.width}px`)
                .css("height", `${size.height}px`);
        };

        this.showOpenDialog = function(){
            return new Promise(function(resolve, reject) {
                var input = document.createElement("INPUT");
                input.setAttribute("type", "file");
                input.style.display = "none";

                document.body.appendChild(input);

                $(input).change(() => {
                    if(input.files.length === 0){
                        reject('ERROR_NOT_SELECT_FILE');
                    }else{
                        resolve(input.files[0]);
                    }
                });
                input.click();
                setTimeout(function(){
                    input.remove();
                }, 2000); //5秒后删除
            })
        };

        this.uploadFile = function(file){
            return new Promise(function(resolve, reject){
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route("image.headmatting") }}", true);
                xhr.responseType = "blob";
                //xhr.setRequestHeader("Content-Type","multipart/form-data");//设置请求内容类型

                xhr.onreadystatechange = function() {
                    if (xhr.readyState !== 4) {
                        return;
                    }
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        resolve(xhr.response);
                    } else {
                        reject('ERROR_UPLOAD_ERROR');
                    }
                };
                var fd = new FormData();
                fd.append("file", file);
                fd.append("_token", "<?php echo e(csrf_token()); ?>");
                xhr.send(fd);
            });
        };

        this.download = function(){
            var canvas = document.querySelector("#image-canvas");
            var url = canvas.toDataURL("image/jpeg");

            var link = document.createElement("a");
            link.style.display = "none";
            link.href = url;
            link.setAttribute("download", "证件照.jpg");
            document.body.appendChild(link);
            link.click();

            setTimeout(link.remove, 1000);
        };
    };

    $(function () {
        let app = new HeadMatting();
        app.init();
    });
</script>
</body>
</html>
