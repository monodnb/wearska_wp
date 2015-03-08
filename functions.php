<?php
/**
 * wearska functions and definitions
 *
 * @package wearska
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

global $wskfw;

if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'wsk_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wsk_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wearska, use a find and replace
	 * to change 'wsk' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wsk', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 960, 960, true ); // Normal post thumbnails
	add_image_size('post-thumb', 960, 960, true);
	add_image_size('ajax-flexslider', 800, 600, true);
	add_image_size('post-main', 2560, 1440, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'wsk' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wsk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // wsk_setup
add_action( 'after_setup_theme', 'wsk_setup' );

/**
 * Add SVG upload support.
 */
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/**
 * Custom walker.
 *
 */

class wsk_walker extends Walker_Nav_Menu
{
	function start_el(&$output, $object, $depth = 0, $args = Array() , $current_object_id = 0) {

		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;
		$classes = array_slice($classes,1);

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';



		$attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
		$attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
		$attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
		$attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';


		if($object->object == 'page')
		{              
			$wsk_menu_icon = get_post_meta($object->object_id, "wsk_menu_icon", true);
			
			$output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';
			
			$object_output = $args->before;
			$object_output .= '<a class="material"'. $attributes .' bubble-size="big">';
			$object_output .= $args->link_before .$wsk_menu_icon;
			$object_output .= apply_filters( 'the_title', $object->title, $object->ID ).$args->link_after;
			$object_output .= '</a>';
			$object_output .= $args->after;   

			$output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );         
		}

	}
}






/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wsk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'wsk' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'wsk_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wsk_scripts() {
	wp_enqueue_style( 'wsk-style', get_stylesheet_uri() );
		
	//wp_enqueue_Style( 'wsk-mobile', ("http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"), false);
	
	wp_deregister_script('jquery');

	wp_register_script('jquery', ("http://code.jquery.com/jquery-latest.min.js"), false);

	wp_enqueue_script('jquery');
	
	//wp_deregister_script('jquery-mobile');

	//wp_register_script('jquery-mobile', ("http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"), false);

	//wp_enqueue_script('jquery-mobile');
	
	//wp_enqueue_script( 'wsk-main', get_template_directory_uri() . '/js/main.js', array(), false );

	wp_enqueue_script( 'wsk-navigation', get_template_directory_uri() . '/js/navigation.js', array(), false );
	
	wp_enqueue_script( 'wsk-ajax-loading', get_template_directory_uri() . '/js/ajax-loading.js', array(), false );
	
	wp_enqueue_script( 'wsk-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wsk_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
* Include Meta Box Framework.
*/
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/inc/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/inc/meta-box' ) );

require_once RWMB_DIR . 'meta-box.php';
include_once get_template_directory() . '/inc/meta-boxes.php';
/**
 * Include Redux Framework.
 */
include_once get_template_directory() . '/inc/options-init.php';
/**
 * Load Portfolio.
 */
require get_template_directory() . '/inc/wearska-portfolio.php';