(function(g){
    function sliceFile(file, size) {
        var fileList = [];

        var location = 0;
        while (location < file.size) {
            fileList.push(file.slice(location, Math.min(location + size, file.size)));
            location += size;
        }
        return fileList;
    }

    let uploader = function(file, options){
        let {url, headers, chunkSize, data} = options
        headers = headers ?? {};
        chunkSize = chunkSize || 1024*1024*1;
        data = data ?? {};

        var files = sliceFile(file, chunkSize);

        var fileid = `file-${randomString(7)}`;

        return new Promise((resolve, reject) => {
            files.forEach( (file, index) => {
                let formData = new FormData();
                formData.append("id", fileid);
                formData.append("file", file);
                formData.append("chunk", index);
                formData.append("chunks", files.length);
                for(let key in data){
                    formData.append(key, data[key]);
                }

                $.ajax({
                    url:url,
                    type:"post",
                    headers:headers,
                    data:formData,
                    dataType:"json",
                    processData:false,
                    contentType:false,
                    success:function(data){
                        if(data.url){
                            resolve(data);
                        }
                    },
                    error:reject,
                });
            })
        });
    };

    g.uploader = uploader;
})(window);

