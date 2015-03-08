(function ($, window, document) {

    // The $ is now locally scoped 
    $(function () {

        // DOM ready!
        //Variables
        $document = $(document),
            $window = $(window),
            $header = $("#header"),
            $navigation = $("#navigation"),
            $toggle = $(".menutoggle"),
            $menu = $(".mainnav"),
            $menuoverlay = $(".overlay"),
            $material = $(".material"),
            $bubblewrap = $(".bubblewrap"),
            vpHeight = $(window).height(),
            hdrHeight = $("#header").height(),
            navHeight = vpHeight - hdrHeight;

        // Initial setup
        $material.wrap('<div class="bubblewrap"></div>')

        // Event delegation
        $toggle.on("click", wskMenuRollout);
        $window.on("load resize scroll", wskMenuHeight);
        $material.on("touchstart", wskShowTouchBubble);
        $document.on("touchend touchcancel", wskHideTouchBubble);
        //wskMenuDragout();

    });

    // Functions
    function wskMenuHeight() { //sets the header height * called on window load, resize & scroll
        $navigation.css("height", navHeight);
    }

    function wskMenuRollout() { //rolls-out the menu on click
        $menuoverlay.toggleClass("transparent");
        $menu.addClass("fastest-transition").toggleClass("rolled-out");
        $toggle.find(".menubutton").toggleClass("open");
        $toggle.find(".line").toggleClass("open");
    }

    function wskShowTouchBubble(startEvent) {
        $(".touchbubble").remove();
        var $this = $(this),
            xStartPos = parseInt(startEvent.originalEvent.touches[0].pageX),
            $bubblewrap = $this.parent(),
            bubbleSize = $this.attr("bubble-size"),
            wrapped = false,
            parentHeight = $this.parent().height(),
            parentPosition = $this.parent().offset().left,
            thisWidth;
        $(this).parent().append('<div class="touchbubble ' + bubbleSize + 'bubble normal animated inflate"></div>');
        thisWidth = $(this).parent().find(".touchbubble").width();
        console.log(parentPosition);
        $(".touchbubble").css({
            left: xStartPos - thisWidth / 2 - parentPosition + "px",
            top: parentHeight / 2 - thisWidth / 2 + "px"
        });
    }

    function wskHideTouchBubble(endEvent) {
        $(".touchbubble").fadeOut(100);
    }

    function wskMenuDragout() {
        var menuWidth = $menu.width(),
            menuInitPos,
            menuPos,
            menuVisibleWidth,
            xStartPos,
            yStartPos,
            xMovePos,
            yMovePos,
            xEndPos,
            yEndPos;

        $document.on("touchstart", function (startEvent) {
            xStartPos = startEvent.originalEvent.touches[0].pageX;
            yStartPos = startEvent.originalEvent.touches[0].pageY;
            $menu.removeClass("fastest-transition");
            menuInitPos = $menu.css("left");
            $document.on("touchmove", function (moveEvent) {
                menuPos = $menu.css("left");
                if (xStartPos < 20 && !$menu.hasClass("rolled-out" && xMovePos >= xStartPos)) {
                    xMovePos = moveEvent.originalEvent.touches[0].pageX;
                    if (parseInt(menuPos) < 0) {
                        $menu.css("left", xMovePos - menuWidth);
                    } else if (parseInt(menuPos) >= 0) {
                        $menu.css("left", "0");
                    }
                } else if (xStartPos > parseInt(menuWidth / 2) && $menu.hasClass("rolled-out") && xMovePos <= xStartPos) {
                    xMovePos = moveEvent.originalEvent.changedTouches[0].pageX;
                    if (parseInt(menuPos) <= 0) {
                        $menu.css("left", xMovePos - menuWidth);
                    } else if (parseInt(menuPos) > 0) {
                        $menu.css("left", "0");
                    }
                } else {
                    //$document.off("touchmove").off("touchend").off("touchcancel");
                }
            });
            $document.on("touchend touchcancel", function (endEvent) {
                $document.off("touchmove").off("touchend").off("touchcancel");
                menuVisibleWidth = parseInt(menuWidth) - Math.abs(parseInt(menuPos));
                if (Math.abs(parseInt(menuPos)) < menuWidth / 2) {
                    $menu.removeAttr("style");
                    wskMenuRollout();
                } else {
                    $menu.addClass("fastest-transition").removeClass("rolled-out").removeAttr("style");
                }
            });
        });
    }

}(window.jQuery, window, document)); // Fully reference jQuery after this point.