// remap jQuery to $
(function ($) {
	var wskClickedLink;
	var wskProjectLink;
	var wskThisProject;
	var wskThisAjax;
	var wskThisAjaxMedia;
	var wskThisAjaxInfo;
	var ajaxContentHeight;
	var ajaxContentWidth;
	
	function wskPushDownPostClick() {
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

			wskThisProject = wskClickedLink.closest('.wskpf-post');
			wskThisAjax = wskThisProject.find('.wskpf-post-ajax');
			wskThisAjaxContent = wskThisAjax.find('.ajax-content-wrap');
			wskThisAjaxMedia = wskThisAjax.find('.project-media');
			wskThisAjaxInfo = wskThisAjax.find('.project-info');	
			wskThisAjax.toggleClass('wskpf-active-post');
			$('.wskpf-post-ajax').not(wskThisAjax).removeClass('wskpf-active-post');


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
				setTimeout(function () {
					$('.project-media').not(wskThisAjaxMedia).empty();
					$('.project-info').not(wskThisAjaxInfo).empty();
					$('.wskpf-post-ajax').not(wskThisAjax).css({
						height: '0',
						marginTop: '0',
						marginBottom: '0'
					});
				}, 600);
			}
			
			function closeProject() {
				fadeOutProject();
				setTimeout(function () {
					wskThisAjaxMedia.empty();
					wskThisAjaxInfo.empty();
					$('.project-media').not(wskThisAjaxMedia).empty();
					$('.project-info').not(wskThisAjaxInfo).empty();
					wskThisAjax.css({
						height: '0',
						marginTop: '0',
						marginBottom: '0'
					});
				}, 600);
			}
			
			
			function showLoader() {
				wskClickedLink.find('img').hide();
				wskClickedLink.addClass('loading-bubbles');
			}

			function hideLoader() {
				if (wskThisAjaxMedia.children().length > 0) {
					wskClickedLink.find('img').fadeIn(600);
					wskClickedLink.removeClass('loading-bubbles');
					ajaxContentHeight = wskThisAjaxContent.outerHeight();
					console.log(ajaxContentHeight);
					wskThisAjax.css({
						height: ajaxContentHeight,
						marginTop: '20px',
						marginBottom: '20px'
					});
					setTimeout(fadeInProject, 600);
				}
			}
			
			function loadProject() {
				wskProjectLink = wskClickedLink.attr("href");
				wskThisAjaxMedia.load(wskProjectLink + ' .post-media', function (response, status) {
					if (status == "success") {
						loadCarousel();
					}
				});
				wskThisAjaxInfo.load(wskProjectLink + ' .project-info > *');
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
						smoothHeight: true
					});
				}
			}
		});
	}

	$(document).ready(function () {
		wskPushDownPostClick();
	});

})(window.jQuery);