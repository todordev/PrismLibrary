var PrismUIHelper = {
		
	displayMessageSuccess: function(title, text, styling, icon) {
	    var options = {
            text: text,
            type: "success"
        };

	    if (title) {
            options.title = title;
        }

        if (!icon) {
            icon = false; // fa fa-check-circle, icon-ok, glyphicon glyphicon-ok-sign
        }
        options.icon = icon;

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }
        options.styling = styling;

	    new PNotify(options);
	},
	displayMessageFailure: function(title, text, styling, icon) {

        var options = {
            text: text,
            type: "error"
        };

        if (title) {
            options.title = title;
        }

        if (!icon) {
            icon = false; // fa fa-exclamation-circle, icon-ok, glyphicon glyphicon-ok-sign
        }
        options.icon = icon;

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }
        options.styling = styling;

        new PNotify(options);
	},
	displayMessageWarning: function(title, text, styling, icon) {

        var options = {
            text: text,
            type: "warning"
        };

        if (title) {
            options.title = title;
        }

        if (!icon) {
            icon = false; // fa fa-exclamation-circle, icon-ok, glyphicon glyphicon-ok-sign
        }
        options.icon = icon;

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }
        options.styling = styling;

		new PNotify(options);
	},
	displayMessageInfo: function(title, text, styling, icon) {

        var options = {
            text: text,
            type: "info"
        };

        if (title) {
            options.title = title;
        }

        if (!icon) {
            icon = false; // fa fa-info-circle, icon-ok, glyphicon glyphicon-ok-sign
        }
        options.icon = icon;

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }
        options.styling = styling;

        new PNotify(options);
	},

    extend: function() {
        for (var i=1; i < arguments.length; i++) {
            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key)) {
                    arguments[0][key] = arguments[i][key];
                }
            }
        }
        return arguments[0];
    }
};