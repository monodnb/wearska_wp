<?php
/* Template Name: Portfolio */
get_header(); ?>

<?php
global $wskfw;
?>

<div id="portfolio" data-role="page" data-dom-cache="false">
	<div class="row">
		<div id='wskpf' class="large-12 columns">
			<?php
		switch($wskfw['opt-projects-display']) {
			case '1' : get_template_part('inc/portfolio/default-portfolio'); break;
			case '2' : get_template_part('inc/portfolio/push-down-portfolio'); break;
			case '3' : get_template_part('inc/portfolio/slide-in-portfolio'); break;
			case '4' : get_template_part('inc/portfolio/lightbox-portfolio'); break;
			case '5' : get_template_part('inc/portfolio/single-page-portfolio'); break;
			default  : get_template_part('inc/portfolio/default-portfolio'); break;
		}
			?>
		</div>
	</div>
</div>


<?php get_footer(); ?>
