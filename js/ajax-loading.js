(function ($) {

	function getData() {
		$(".menu-item a").on("click", function (e) {
			e.preventDefault();
			var linkURL = $(this).attr("href");
			$.ajax({
				// the URL for the request
				url: linkURL,

				// whether this is a POST or GET request
				type: "GET",

				// function to call before we send the AJAX request
				beforeSend: startFn,

				// function to call for success
				success: successFn,

				// function to call on an error
				error: errorFn,

				// code to run regardless of success or failure
				complete: function (xhr, status) {
					console.log("The request is complete!");
				}
			});
		});
	}

	function startFn() {
		$("#page-content").children().remove();
	}

	function successFn(result) {
		$("#page-content").append($(result).find('[data-role="page"]'));
	}

	function errorFn(xhr, status, strErr) {
		console.log("There was an error!");
	}

	$("document").ready(function () {
		getData();
	});


})(jQuery); // Fully reference jQuery after this point.