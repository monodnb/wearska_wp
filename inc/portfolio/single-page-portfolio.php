<?php
global $wskfw;
switch($wskfw['opt-projects-display']) {
	case '4' : $projectDisplayTypeClass = 'wskpf-display-single-page'; break;
}
?>

<?php
wp_enqueue_style( 'lightbox-grid-css', get_template_directory_uri() . '/inc/portfolio/css/portfolio-single-page.css', array() );
?>

<!-- Start Projects Grid -->
<div id="wskpf-grid" class="single-page-grid">

	<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$port_args = array(
	'post_type' 				=> 'portfolio',
	'posts_per_page' 			=> $wskfw['opt-visible-projects'],
	'post_status' 				=> 'publish',
	'orderby' 					=> 'menu_order',
	'order' 					=> 'ASC',
	'paged' 					=> $paged
);	
	?>

	<?php $wp_query = new WP_Query( $port_args ); ?>

	<?php if ( $wp_query->have_posts() ) : ?>

	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
	
	<?php
		$title= str_ireplace('"', '', trim(get_the_title()));
		$desc= str_ireplace('"', '', trim(get_the_content()));
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'post-thumb', true);
		$external_content = rwmb_meta('projectexternallinkurl');
		$portfolio_type = rwmb_meta('wskpfprojecttype');

		switch($portfolio_type) {
			case '0' : $projectTypeButtonClass = 'wskpf-type-image-slider'; break;
			case '1' : $projectTypeButtonClass = 'wskpf-type-external-link'; break;
			case '2' : $projectTypeButtonClass = 'wskpf-type-youtube-video'; break;
			case '3' : $projectTypeButtonClass = 'wskpf-type-soundcloud-audio'; break;	
			default : $projectTypeButtonClass = 'wskpf-type-image-slider'; break;
		}

		switch($portfolio_type) {
			case '0' : $projectTypeIcon = get_template_directory_uri() . '/img/icons/slider.svg'; break;
			case '1' : $projectTypeIcon = get_template_directory_uri() . '/img/icons/link.svg'; break;
			case '2' : $projectTypeIcon = get_template_directory_uri() . '/img/icons/play.svg'; break;
			case '3' : $projectTypeIcon = get_template_directory_uri() . '/img/icons/soundcloud.svg'; break;	
			default :  $projectTypeIcon = get_template_directory_uri() . '/img/icons/image.svg'; break;
		}
	?>
	<div class="wskpf-post">
		<div class="wskpf-post-thumb">
			<div class="wskpf-post-overlay">
				<div class="wskpf-post-icons">
					<a href="<?php the_permalink(); ?>" class="icon <?php print $projectDisplayTypeClass; ?> <?php print $projectTypeButtonClass; ?>" rel="<?php the_ID(); ?>" external="<?php print $external_content; ?>">
						<img src="<?php print $projectTypeIcon ?>" /></a>
				</div>
			</div>
			<div class="wskpf-img-container" image-data="<?php echo $image_url[0];?>" alt=""></div>
		</div> <!--wskpf-post-thumb-->
	</div>
	<?php endwhile; ?>
</div>
<div id="wskpf-pagination">
	<?php posts_nav_link('','',__('Load More Posts', 'wearska')); ?>
</div>
	
<?php wp_reset_postdata(); ?>
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<!-- End Projects Grid -->