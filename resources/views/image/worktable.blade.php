
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
            <div class="card">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">证件照换背景色</h4>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm" id="file-select-btn"><i class="fa fa-upload" aria-hidden="true"></i> 选择图片</button>
                    <div class="pricing-header px-3 py-1 mx-auto text-center">
                        <p class="lead">任意一张带有正脸人物头像的照片，即可轻松处理为证件照</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="image-face">
                            <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22250%22%20height%3D%22350%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20250%20350%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_158bd1d28ef%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_158bd1d28ef%22%3E%3Crect%20width%3D%22250%22%20height%3D%22350%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%0A%3Ctext%20x%3D%2250%25%22%20y%3D%2245%25%22%20dy%3D%22.3em%22%20text-anchor%3D%22middle%22%20font-family%3D%22MSYH%22%3E%E7%82%B9%E5%87%BB%20%5B%E9%80%89%E6%8B%A9%E5%9B%BE%E7%89%87%5D%3C%2Ftext%3E%0A%3Ctext%20x%3D%2250%25%22%20y%3D%2255%25%22%20dy%3D%22.3em%22%20text-anchor%3D%22middle%22%20font-family%3D%22MSYH%22%3E%20%E4%B8%8A%E4%BC%A0%E4%BB%BB%E6%84%8F%E6%AD%A3%E9%9D%A2%E5%9B%BE%3C%2Ftext%3E%0A%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="img-fluid m-auto" style="width: 250px;height: 350px;background-color: #dee2e6" id="image-face-img"></img>
{{--                            <svg width="250" height="350" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 250 350">--}}
{{--                                <defs><style type="text/css">#holder_158bd1d28ef text { fill:rgba(255,255,255,.75);font-weight:normal;font-family:Helvetica, monospace;font-size:16pt } </style></defs>--}}
{{--                                <g id="holder_158bd1d28ef">--}}
{{--                                    <rect width="250" height="350" fill="#777"></rect>--}}
{{--                                    <g>--}}
{{--                                        <text x="50%" y="45%" dy=".3em" text-anchor="middle" font-family="MSYH">点击 [选择图片]</text>--}}
{{--                                        <text x="50%" y="55%" dy=".3em" text-anchor="middle" font-family="MSYH"> 上传任意正面图</text>--}}
{{--                                    </g>--}}
{{--                                </g>--}}
{{--                            </svg>--}}
                        </div>
                        <div class="col-md-12 m-0 pt-3">
                            <div class="btn-group btn-group-sm pt-1" aria-label="Basic example">
                                <button type="button" class="btn btn-info ml-1">背景色</button>
                                <button type="button" class="btn btn-primary head-back-color-btn head-back-btn-white" style="">白</button>
                                <button type="button" class="btn btn-primary head-back-color-btn head-back-btn-red">红色</button>
                                <button type="button" class="btn btn-primary head-back-color-btn head-back-btn-blue">蓝色</button>
                            </div>
                            <div class="btn-group btn-group-sm pt-1">
                                <button type="button" class="btn btn-info" data-size="250*350">1寸</button>
                                <button type="button" class="btn btn-info" data-size="350*490">2寸</button>
                                <button type="button" class="btn btn-info" data-size="350*520">3寸</button>
                                <button type="button" class="btn btn-info ml-1" data-size="250*350">港澳台</button>
                                <button type="button" class="btn btn-info" data-size="350*490">2寸</button>
                                <button type="button" class="btn btn-info" data-size="350*520">3寸</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-block btn-primary mt-4">下载</button>
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
<script src="https://cdn.bootcdn.net/ajax/libs/webuploader/0.1.1/webuploader.min.js"></script>
<script>
    var HeadMatting = function(){
        var imageBlob;

        this.setImage = function(image){
            imageBlob = image;

            var reader = new window.FileReader();
            reader.readAsDataURL(image);
            reader.onloadend = function() {
                $("#image-face-img").attr("src", reader.result);
            };

        };
    };

    $(function () {
        let app = new HeadMatting();

        let uploader = WebUploader.create({
            server: "{{ route("image.headmatting") }}",
            pick: '#file-select-btn',
            resize: false,
            chunked: false,
            //chunkSize: 1024 * 1024,         //每次分片1M
            fileNumLimit: 1,
            auto: true,
            duplicate: true,
            //fileSizeLimit: 2 * 1024 * 1024,    //最大2M
            accept: {
                mimeTypes: 'image/*'
            },
            threads: 1,
            fileVal:"{{ \App\Supports\Uploader::ATTR_VAL_FILE }}",
            formData: {
                _token:'{{ csrf_token() }}'
            }
        });
        uploader.on("uploadStart", function () {
            console.log(this)
        });
        uploader.on("beforeFileQueued", function(file){
            file.id = WebUploader.Base.guid("file");
            return file;
        });
        uploader.on("uploadSuccess", (file, response) => {
            app.setImage(new Blob([response._raw]));
        });
        window.uploader = uploader;
    });
</script>
</body>
</html>
