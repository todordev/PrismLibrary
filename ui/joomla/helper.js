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
		
	}
};