if (Prism === undefined) {
    var Prism = {
        extend: function () {
            for (let i = 1; i < arguments.length; i++) {
                for (let key in arguments[i]) {
                    if (arguments[i].hasOwnProperty(key)) {
                        arguments[0][key] = arguments[i][key];
                    }
                }
            }
            return arguments[0];
        }
    };

    Prism.message = {
        show(message) {
            if (!message) {
                throw new Error('Invalid message object!');
            }

            let pNotifyOptions = {
                text: message.content
            };

            if (message.title) {
                pNotifyOptions.title = message.title;
            }

            if (!message.type) {
                message.type = 'success'; // success, warning, error, info
            }
            pNotifyOptions.type = message.type;

            if (!message.icon) {
                message.icon = false; // fa fa-check-circle, icon-ok, glyphicon glyphicon-ok-sign
            }
            pNotifyOptions.icon = message.icon;

            if (!message.styling) {
                message.styling = 'brighttheme'; // brighttheme, material, fontawesome
            }
            pNotifyOptions.styling = message.styling;

            PNotify.alert(pNotifyOptions);
        }
    };
}
