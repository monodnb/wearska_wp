<?php
/*
A portfolio post type for Wearska
Version: 0.3
79thor: Ionut Achim
Author URI: http://wearska.com
*/

// **********************************
// Create the Portfolio post type
// **********************************
   
function wearska_portfolio_register() {
    $labels = array(
		'name' => __( 'Portfolio', 'wearska' ),
		'singular_name' => __( 'Portfolio Item', 'wearska' ),
		'add_new' => __( 'Add New', 'wearska' ),
		'edit_item' => __( 'Edit Item', 'wearska' ),
		'view_item' => __( 'View Item', 'wearska' ),
		'search_items' => __( 'Search Portfolio', 'wearska' ),
		'not_found' => __( 'No portfolio items found', 'wearska' ),
		'not_found_in_trash' => __( 'No portfolio items found in trash', 'wearska' )
	);
	
    $args = array(  
        'labels' => $labels, 
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => array('slug' => 'portfolio-item'), 
        'supports' => array('title', 'editor', 'thumbnail', 'comments')  
       );  
  
    register_post_type( 'portfolio' , $args );  
}


add_action('init', 'wearska_portfolio_register');  

// *************************************
// Taxonomy
// *************************************


function wearska_custom_taxonomy() {
    register_taxonomy(
        'project_type', 'portfolio',  
	array(  
	    'hierarchical' => true,  
	    'labels' => array(
	    	'name' => __( 'Categories', 'wearska' ),
	    	'singular_name' => __( 'Portfolio Category', 'wearska' ),
	    	'search_items' => __( 'Search Portfolio Categories', 'wearska' ),
	    	'popular_items' => __( 'Popular Portfolio Categories', 'wearska' ),
	    	'all_items' => __( 'All Portfolio Categories', 'wearska' ),
	    	'edit_item' => __( 'Edit Portfolio Category', 'wearska' ),
	    	'update_item' => __( 'Update Portfolio Category', 'wearska' ),
	    	'add_new_item' => __( 'Add New Portfolio Category', 'wearska' ),
	    	'new_item_name' => __( 'New Portfolio Category Name', 'wearska' ),
	    	'separate_items_with_commas' => __( 'Separate Portfolio Categories With Commas', 'wearska' ),
	    	'add_or_remove_items' => __( 'Add or Remove Portfolio Categories', 'wearska' ),
	    	'choose_from_most_used' => __( 'Choose From Most Used Portfolio Categories', 'wearska' ),  
	    	'parent' => __( 'Parent Portfolio Category', 'wearska' )      	
	    	),
	    'query_var' => true,  
	    'rewrite' => true  
		)  
    );
}

add_action('init', 'wearska_custom_taxonomy');

// *************************************
// Customize Admin Portfolio Columns
// *************************************

function manage_portfolio_columns( $portfolio_columns ) {
	$portfolio_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __('Title' ,'wearska'),
		"thumbnail" => __('Thumbnail', 'wearska'),
		"author" => __('Author', 'wearska'),
		"date" => __('Date', 'wearska'),
	);
	return $portfolio_columns;
}

function display_portfolio_column( $portfolio_columns, $post_id ) {

	// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
	
	switch ( $portfolio_columns ) {
		
		// Display the thumbnail in the column view
		case "thumbnail":
			$width = (int) 75;
			$height = (int) 75;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb;
			} else {
				echo __('None', 'wearska');
			}
			break;	
		case "project_type":
		
		if ( $category_list = get_the_term_list( $post_id, 'project_type', '', ', ', '' ) ) {
			echo $category_list;
		} else {
			echo __('None', 'wearska');
		}
		break;			
	}
}

add_filter( 'manage_edit-portfolio_columns', 'manage_portfolio_columns' );
add_action( 'manage_posts_custom_column', 'display_portfolio_column', 10, 2 );

// **********************************
//        Helper functions
// **********************************

add_filter('excerpt_length', 'my_excerpt_length');
 
function my_excerpt_length($length) {
 
    return 25; 
 
}
 
add_filter('excerpt_more', 'new_excerpt_more');  
 
function new_excerpt_more($text){  
 
    return ' ';  
 
}  
 
function portfolio_thumbnail_url($pid){
    $image_id = get_post_thumbnail_id($pid);  
    $image_url = wp_get_attachment_image_src($image_id,'screen-shot');  
    return  $image_url[0];  
}

function wearska_portfolio_get_preview_image($post_id, $size = 'full'){
	if( $post_id !== 0){
		$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );
		if(isset($thumb_src[0])){
			return $thumb_src[0];	
		}
	}
	return "";
}

function wearska_portfolio_get_description($custom_meta){
	// Post Description
	if(isset($custom_meta['wearska_portfolio_intro_text'])){
		$work_description = $custom_meta['wearska_portfolio_intro_text'][0];	
	}else{
		// TODO: exctract from the posts content
		$work_description = "";
	}
	
	return $work_description;
}

//TODO: move this to theme's function.php

// Gets the ID of an attachment given its URL.

function wearska_get_attachment_id( $guid ) {
  global $wpdb;

  /* nothing to find return false */
  if ( ! $guid )
    return false;

  /* get the ID */
  $id = $wpdb->get_var( $wpdb->prepare(
    "
    SELECT  p.ID
    FROM    $wpdb->posts p
    WHERE   p.guid = %s
            AND p.post_type = %s
    ",
    $guid,
    'attachment'
  ) );

  /* the ID was not found, try getting it the expensive WordPress way */
  if ( $id == 0 )
    $id = url_to_postid( $guid );

  return $id;
}


?>