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
        var filename = file.name;
        var fileid = `file-${randomString(7)}`;

        return new Promise((resolve, reject) => {
            let progressRate = 0;
            let progressRateCount = files.length;

            files.forEach( (file, index) => {
                let formData = new FormData();
                formData.append("id", fileid);
                formData.append("file", file);
                formData.append("chunk", index);
                formData.append("chunks", files.length);
                formData.append("name", filename);
                for(let key in data){
                    formData.append(key, data[key]);
                }

                $.ajax({
                    url:url,
                    type:"post",
                    headers:headers,
                    data:formData,
                    dataType:"json",
                    async:false,
                    processData:false,
                    contentType:false,
                    success:function(data){
                        progressRate++;
                        if(progressRate >= progressRateCount){
                            resolve(data);
                        }
                    },
                    error:function(){
                        //TODO 中断后续分片上传
                        reject(arguments)
                    },
                });
            })
        });
    };
    g.uploader = uploader;
})(window);

