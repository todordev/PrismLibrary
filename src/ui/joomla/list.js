jQuery(document).ready(function() {
	
	// Initialize ordering
	Joomla.orderTable = function() {
		var table 	  	= document.getElementById("sortTable");
		var direction 	= document.getElementById("directionTable");
		var order 		= table.options[table.selectedIndex].value;
		var listOrder   = document.getElementById("filter_order").value;

        var dirn        = direction.options[direction.selectedIndex].value;
		if (order != listOrder) {
			dirn = 'asc';
		}

		Joomla.tableOrdering(order, dirn, '');
	};
	
	// Initialize button "Clear"
	jQuery("#js-search-filter-clear").on("click", function(){
		jQuery('#filter_search').val("");
		jQuery("#adminForm").submit();
	});
	
});