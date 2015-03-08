<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package wearska
 */
?>

<?php
global $wskfw;
$loaderLogo = $wskfw['opt-loading-logo']
?>
    </div>
    <!-- #content -->

    <footer id="footer" class="row hide"></footer>
    <!-- #colophon -->

    <div id="loadcontainer" class="hide row">
        <div class="loader clickable">
            <div class="loaderimage"><img src='<?php echo $loaderLogo["url"]?>' alt="logo" /></div>
            <svg class="spinner" width="100px" height="100px" viewBox="0 0 102 102" xmlns="http://www.w3.org/2000/svg">
                <circle class="path" fill="none" stroke-width="2" stroke-linecap="round" cx="51" cy="51" r="50"></circle>
            </svg>
        </div>
    </div>
</div>
<!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
