var PrismUIHelper = {
		
	displayMessageSuccess: function(title, text, styling, icon) {

        if (!icon) {
            icon = 'fa fa-check-circle'; // icon-ok, glyphicon glyphicon-ok-sign
        }

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }

	    new PNotify({
	        title: title,
	        text: text,
	        icon: icon,
	        type: "success",
            styling: styling
        });
	},
	displayMessageFailure: function(title, text, styling, icon) {

        if (!icon) {
            icon = 'fa fa-exclamation-circle'; // icon-warning-sign, glyphicon glyphicon-warning-sign
        }

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }

        new PNotify({
	        title: title,
	        text: text,
	        icon: icon,
	        type: "error",
            styling: styling
        });
	},
	displayMessageWarning: function(title, text, styling, icon) {

        if (!icon) {
            icon = 'fa fa-exclamation-circle'; // icon-warning-sign, glyphicon glyphicon-warning-sign
        }

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }

		new PNotify({
			title: title,
			text: text,
			icon: icon,
			type: "warning",
            styling: styling
		});
	},
	displayMessageInfo: function(title, text, styling, icon) {

        if (!icon) {
            icon = 'fa fa-info-circle'; // icon-info, glyphicon glyphicon-info-sign
        }

        if (!styling) {
            styling = 'bootstrap3'; // brighttheme, jqueryui, fontawesome
        }

        new PNotify({
	        title: title,
	        text: text,
	        icon: icon,
	        type: "info",
            styling: styling
        });
		
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