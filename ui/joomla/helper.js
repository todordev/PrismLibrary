var PrismUIHelper = {
		
	displayMessageSuccess: function(title, text) {
		
	    new PNotify({
	        title: title,
	        text: text,
	        icon: "icon-ok",
	        type: "success"
        });
	},
	displayMessageFailure: function(title, text) {

        new PNotify({
	        title: title,
	        text: text,
	        icon: 'icon-warning-sign',
	        type: "error"
        });
	},
	displayMessageInfo: function(title, text) {

        new PNotify({
	        title: title,
	        text: text,
	        icon: 'icon-info',
	        type: "info"
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