/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function ($) {

    /*----------------------------------------------------*/
    /* LOADER
    /*----------------------------------------------------*/

    function wskCreateLoader() {
		$(".loader").on("click", function() {
			var $this = $(this);
			if ($this.hasClass("clickable")){
				$this.addClass("poke animated linear fast").removeClass("clickable");
				setTimeout(function () {
					$this.removeClass("poke animated linear fast").addClass("clickable");
				}, 500);
			}
		});
    }

    $(document).ready(function () {
        wskCreateLoader();
    });
	
	$(window).on("load", function () {
		$(".loader").click();
	});


    /*----------------------------------------------------*/
    /* PORTFOLIO AJAX PAGINATION
    /*----------------------------------------------------*/

    $.fn.exists = function (callback) {
        var args = [].slice.call(arguments, 1);

        if (this.length) {
            callback.call(this, args);
        }

        return this;
    };

    window.wskPortfolioAjaxPagination = function() {
        $("#wskpf-pagination").exists(function () {
            $(document).on("scroll", function () {
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
                            $('#wskpf').find('#ajax-content-holder').remove();
                        }
                    });
                }
            });
        });
    }

    // Use this variable to set up the common and page specific functions. If you 
    // rename this variable, you will also need to rename the namespace below.
    var Ska = {
        // All pages
        common: {
            init: function () {
                // JavaScript to be fired on all pages
                $(document).on("pagechange", function () {
                    //wskPostClickInteraction();
                    //wskPortfolioScroll();
                    //wskPortfolioAjaxPagination();
                });

            }
        },
        // Home page
        home: {
            init: function () {
                // JavaScript to be fired on the home page
            }
        },
        // About us page, note the change from about-us to about_us.
        about_us: {
            init: function () {
                // JavaScript to be fired on the about us page
            }
        },
        // Portfolio.
        page_template_portfolio: {
            init: function () {
                // JavaScript to be fired on the portfolio page
                $(document).ready(function () {
                    // wskPostClickInteraction();
                    // wskPortfolioScroll();
                    // wskPortfolioAjaxPagination();
                });
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function (func, funcname, args) {
            var namespace = Ska;
            funcname = (funcname === undefined) ? 'init' : funcname;
            if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function () {
            UTIL.fire('common');

            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
                UTIL.fire(classnm);
            });
        }
    };
    2
    $(document).ready(UTIL.loadEvents);

})(jQuery);    // Fully reference jQuery after this point.