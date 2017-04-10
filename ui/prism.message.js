if (Prism == undefined) {
    var Prism = {};
}

Prism.message = {
	show: function(message) {
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
            message.styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }
        pNotifyOptions.styling = message.styling;

	    new PNotify(pNotifyOptions);
	}
};