<?php
/**
 * The template used for displaying image-slider-projects
 *
 * @package wearska
 */
$slider_content = rwmb_meta('projectsliderimages', 'type=file');
global $wskfw;
?>


<?php
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'ajax-flexslider', true);
	$image_full_url = wp_get_attachment_image_src($image_id,'featured', true);
?>

<div class="post-media">
	<?php if(!empty($slider_content)) {?>
	    <div class="flexslider">
			<ul class="slides">
				<?php
				foreach ( $slider_content as $info )
				{
                    $extension_pos = strrpos($info['url'], '.'); // find position of the last dot, so where the extension starts
					if($wskfw['opt-projects-display']==1 || $wskfw['opt-projects-display']==2 || $wskfw['opt-projects-display']==3){
						$thumb = substr($info['url'], 0, $extension_pos) . '-800x600' . substr($info['url'], $extension_pos);
						echo "<li><img src='$thumb' /></li>";
					} else {
						$thumb = $info['url'];
						echo "<li><img src='$thumb' /></li>";
					}
                }
				?>
			</ul>
	    </div>
	<?php } else {?>
		<div class="featured-image-container">        
			<?php echo "<a href='$image_full_url[0]' title='$title'><img src='$image_full_url[0]' width='100%' alt='' /></a>"; ?>
		</div>
	<?php }?>
</div>

