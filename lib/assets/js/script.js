(function ($) {

	window.GoodREST = {};

	GoodREST.init = function () {
		GoodREST.generateNewApiKey();
	};

	GoodREST.generateNewApiKey = function () {
		$(document).on("click", "#generate-api-key", function (e) {

			$.ajax({
				url: document.URL,
				dataType: "text",
				data: { good_rest_generate_api_key : true },
				type: "POST",
				timeout: 8000,
				cache: false,
				beforeSend: function( ) {
					
				}
			})
			.fail(function( jqXHR, textStatus, errorThrown) {
				
			})
			.done(function (data) {
				$("#good_rest_api_key").val(data);
			});

			e.preventDefault();
		});
	};

	$(function () {
		GoodREST.init();

	});

})(jQuery);