// remap jQuery to $
(function ($) {
	var wskClickedLink;
	var wskProjectLink;
	var wskThisProject;
	var wskThisAjax;
	var wskThisAjaxMedia;
	var wskThisAjaxInfo;
	var wskThisAjaxNav;
	var wskThisAjaxClose;
	var ajaxContentHeight;
	var ajaxMediaHeight;
	var ajaxContentWidth;

	function wskSlideInPostClick() {
		//ajax global setup
		$.ajaxSetup({
			cache: false
		});

		//link interaction
		$('body').on("click", '.wskpf-post-icons > a', function (e) {
			e.preventDefault();
			//define needed variables
			wskClickedLink = $(this);
			wskClickedLink.toggleClass('current');
			$('.wskpf-post-icons > a').not(wskClickedLink).removeClass('current');

			wskThisAjax = $('#content .wskpf-post-ajax');
			wskThisAjaxContent = wskThisAjax.find('.ajax-content-wrap');
			wskThisAjaxMedia = wskThisAjax.find('.project-media');
			wskThisAjaxInfo = wskThisAjax.find('.project-info');
			wskThisAjaxNav = wskThisAjax.find('.project-navigation');
			wskThisAjaxClose = wskThisAjax.find('.project-close');


			if (wskClickedLink.hasClass('current')) {
				openProject();
			} else {
				closeProject();
			}

			function openProject() {
				showLoader();
				loadProject();
				fadeOutProject();
				setTimeout(hideLoader, 1200);
			}
			
			function closeProject() {
				fadeOutProject();
				setTimeout(function () {
					wskThisAjaxMedia.empty();
					wskThisAjaxInfo.empty();
					wskThisAjax.removeClass('inflate');
					wskThisAjaxClose.removeClass('slide-in-bottom');
				}, 600);
			}
			
			function showLoader() {
				wskClickedLink.find('img').hide();
				wskClickedLink.addClass('loading-bubbles');
			}
			
			function hideLoader() {
				if (wskThisAjaxInfo.children().length > 0) {
					wskClickedLink.find('img').fadeIn(600);
					wskClickedLink.removeClass('loading-bubbles');
					wskThisAjax.addClass('inflate');
					//wskThisAjaxClose.addClass('slide-in-bottom');
					setTimeout(fadeInProject, 600);
				}
			}
			
			function loadProject() {
				wskProjectLink = wskClickedLink.attr("href");
				wskThisAjaxMedia.load(wskProjectLink + ' .post-media', function (response, status) {
					if (status == "success") {
						loadCarousel();
						ajaxMediaHeight = wskThisAjaxMedia.outerHeight();
						wskThisAjaxInfo.css('height', '370px');
					}
				});
				wskThisAjaxInfo.load(wskProjectLink + ' .project-info > *', function (response, status) {
					if (status == "success") {
						$(".custom-scroll").mCustomScrollbar({
							autoHideScrollbar: false,
							theme: "minimal-dark"
						});
					}
				});
				wskThisAjaxNav.load(wskProjectLink + ' .project-navigation > *');
			}
			
			function hideProject() {
				$('.ajax-content-wrap').hide();
			}
			
			
			function fadeInProject() {
				wskThisAjaxContent.fadeIn(600);
				if (wskThisAjaxMedia.find('.flexslider').length != 0) {
					wskThisAjaxContent.animate({
						opacity: 1}, 600)
				}
				var ajaxContentOffset = wskThisAjaxContent.offset();
				var scrollToPosition = ajaxContentOffset.top;
				$("html, body").animate({
					scrollTop: scrollToPosition
				}, 300);
			}
			
			function fadeOutProject() {
				$('.ajax-content-wrap').fadeOut(600);
			}

			
			function loadCarousel() {
				if (wskThisAjaxMedia.find('.flexslider').length != 0) {
					wskThisAjaxContent.css('opacity','0').show();
					$('.flexslider').flexslider({
						animation: "slide",
						slideDirection: "horizontal",
						slideshow: true,
						slideshowSpeed: 2000,
						animationDuration: 500,
						directionNav: true,
						controlNav: false
					});
				}
			}
			
			$('body').on("click", '.project-close', function (e) {
				closeProject();
			});
		});
	}

	$(document).ready(function () {
		wskSlideInPostClick();
	});

})(window.jQuery);