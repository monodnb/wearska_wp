<?php
    $post = get_post($_POST['id']);
	wp_head();
?>

<?php
	global $wskfw;
	if($wskfw['opt-projects-display']==4) {
		wp_enqueue_style( 'single-page-grid-css', get_template_directory_uri() . '/inc/portfolio/css/portfolio-single-page.css', array() );
	}
?>

<?php while ( have_posts() ) : the_post(); 

    $title= str_ireplace('"', '', trim(get_the_title()));
	$desc= str_ireplace('"', '', trim(get_the_content()));
	$external_content = rwmb_meta('projectexternallinkurl');
    $portfolio_type = rwmb_meta('wskpfprojecttype');?>
<div id="wskpf-project-page">
	<div class="project-navigation">
		<h1><span><?php print $title ?></span></h1>
	</div>
	<div class="project-media">
		<?php switch($portfolio_type) {
			case '0' : get_template_part( 'content', 'slider' ); break;
			case '1' : get_template_part( 'content', 'external' ); break;
			case '2' : get_template_part( 'content', 'youtube' ); break;
			case '3' : get_template_part( 'content', 'soundcloud' ); break;	
			default : get_template_part( 'content', 'slider' ); break;		
		}?>
	</div>
    <div class="project-info">
		<div class="project-description-wrap">
			<h3><span>Project Description</span></h3>
			<p class="project-description custom-scroll"><?php print $desc ?></p>
		</div>
		<div class="project-details-wrapper">
			<h3><span>Project Details</span></h3>
			<p class="project-client"><strong>Client:</strong> John Doe</p>
			<p class="project-tags"><strong>Tags:</strong> Desing, Music, Identity</p>
		</div>
    </div>
</div>
<?php endwhile; // end of the loop. ?>
<?php wp_footer(); ?>