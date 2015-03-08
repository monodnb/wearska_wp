<?php
/**
 * The template used for displaying youtube-projects
 *
 * @package wearska
 */
$youtube_content = rwmb_meta('projectyoutubeid');
?>

<div class="post-media">
       <iframe id="ytplayer" type="text/html" width="100%" height="520" src="https://www.youtube.com/embed/<?php print $youtube_content ?>?showinfo=0&iv_load_policy=3" frameborder="0" allowfullscreen></iframe>
</div>

<?php wp_footer(); ?>