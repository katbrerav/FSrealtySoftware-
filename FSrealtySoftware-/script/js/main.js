// $(document).ready(function(){

// });


$("#propertySelect").select2({
	ajax: {
		url: "/PHP/popertyList.php",
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
				q: params.term // search terms
			};
		},
		processResults: function(data) {
			//parse the results into the format expected by select2
			//since we are using custom formatting functions we do not need

			// alter the remote JSON data
			return {
				results: data
			};
		},

		cache: true
	},
	minimumInputLength: 2
});