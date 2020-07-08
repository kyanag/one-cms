var fileuploader = function(options){


    this.showOpenDialog = function () {
        var input = document.createElement("INPUT");
        input.setAttribute("type", "file");
        input.style.display = "none";


        document.body.appendChild(link);
        link.click();
        setTimeout(input.remove, 5000); //5秒后删除
    }

    this.onFileSelected = function( type/*, args...*/ ) {
        var _events = [];

        var args = [].slice.call( arguments, 1 ),
            opts = this.options,
            name = 'on' + type.substring( 0, 1 ).toUpperCase() +
                type.substring( 1 );

        if (
            // 调用通过on方法注册的handler.
            Mediator.trigger.apply( this, arguments ) === false ||

            // 调用opts.onEvent
            $.isFunction( opts[ name ] ) &&
            opts[ name ].apply( this, args ) === false ||

            // 调用this.onEvent
            $.isFunction( this[ name ] ) &&
            this[ name ].apply( this, args ) === false ||

            // 广播所有uploader的事件。
            Mediator.trigger.apply( Mediator,
                [ this, type ].concat( args ) ) === false ) {

            return false;
        }

        return true;
    },

};