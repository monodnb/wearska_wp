<?php
/**
 * The template used for displaying external links
 *
 * @package wearska
 */
$external_content = rwmb_meta('projectexternallinkurl');
?>

<div class="ajax-content" rel="<?php print $external_content ?>"></div>

<?php wp_footer(); ?>