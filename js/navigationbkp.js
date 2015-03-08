(function ($) {


    function wskTouchBubble() {
        $(".material").on("touchstart", function () {
            console.log("touchstart");
        });
    }

    $("document").ready(function () {
        wskTouchBubble();
    });


})(jQuery); // Fully reference jQuery after this point.