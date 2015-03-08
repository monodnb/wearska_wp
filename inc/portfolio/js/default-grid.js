// remap jQuery to $
(function ($) {


	function wskPostClickInteraction() {
		$(".wskpf-post").on("tap", function () {
			alert("clicked");
			$(".wskpf-post").not($(this)).removeClass("fastest-transition").addClass("normal-transition grayscale");
			$(this).removeClass("normal-transition grayscale").addClass("fastest-transition");
		});
	}

	function wskPortfolioScroll() {
		alert("scroll enabled");
		$(".wskpf-post:first").removeClass("offscreen fastest-transition grayscale").addClass("onscreen slowest-transition");
		$(".wskpf-post:nth-child(2)").removeClass("offscreen fastest-transition grayscale").addClass("onscreen slowest-transition");
		$(window).scroll(function () {
			$(".wskpf-post").each(function () {
				if ($(this).visible(true)) {
					$(this).removeClass("offscreen fastest-transition grayscale").addClass("onscreen slowest-transition");
				} else {
					$(this).removeClass("onscreen slowest-transition").addClass("offscreen fastest-transition grayscale");
				}
			});
		});
	}


	/*----------------------------------------------------*/
	/* PORTFOLIO AJAX PAGINATION
	/*----------------------------------------------------*/


	function wskPortfolioAjaxPagination() {
		alert("pagination enabled");
		$(window).on("scroll", function () {
			if ($(window).scrollTop() + $(window).height() == $(document).height()) {
				var pageLink = $("#wskpf-pagination a").attr("href");
				$('#wskpf').append('<div id="ajax-content-holder" style="display:none;"></div><div id="ajax-content-nextlink" style="display:none;"></div>');
				$('#ajax-content-nextlink').load(pageLink + ' #wskpf-pagination', function (response, status) {
					if (status == "success") {
						var nextPage = $('#ajax-content-nextlink').find('#wskpf-pagination a:nth-child(2)');
						if (!nextPage.length) {
							console.log('no more links');
							$('body #wskpf #wskpf-pagination').empty().append("<p>No More Links</p>");
						}
						var nextPageLink = nextPage.attr("href");
						$('body #wskpf #wskpf-pagination a').attr("href", nextPageLink);
						$('#wskpf').find('#ajax-content-nextlink').remove();
					}
				});
				$('#ajax-content-holder').load(pageLink + ' #wskpf-grid > *', function (response, status) {
					if (status == "success") {
						var postsToLoad = $('#ajax-content-holder').children().clone(true, true);
						postsToLoad.appendTo('body #wskpf #wskpf-grid');
						$(window).resize();
						$('#wskpf').find('#ajax-content-holder').remove();
					}
				});
			}
		});
	}


	$(document).bind("pageshow", function(){
		alert("page show");
		wskPostClickInteraction();
		wskPortfolioScroll();
		wskPortfolioAjaxPagination();
	});

})(window.jQuery);