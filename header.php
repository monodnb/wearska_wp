<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package wearska
 */
?>

<?php
global $wskfw;
$headerLogo = $wskfw['opt-header-logo'];
$featuredLogo = $wskfw['opt-featured-logo'];
$menuButton = $wskfw['opt-menu-button'];
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site small-12 medium-12 large-12 columns">
		<header id="header" class="row sticky-top css3-shadow">
			<div class="menutoggle small-2 columns">
                <div class="menubutton fastest-transition">
                    <div class="line top-line fastest-transition"></div>
                    <div class="line center-line fastest-transition"></div>
                    <div class="line bottom-line fastest-transition"></div>
                </div>
            </div>
            <div class="homebutton small-5 columns">
                <a href="#home"><img src='<?php echo $headerLogo["url"]?>' alt="logo"/></a>
            </div>
			<div class="socialarea small-5 columns">
                <div class="socialbuttons lightning-transition">
                    <div href="#" class="share"><img src="http://wearska.com/ska/wp-content/uploads/2015/03/share11.svg" alt="logo"/></div>
                    <div href="#" class="love"><img src="http://wearska.com/ska/wp-content/uploads/2015/03/plain13.svg" alt="logo"/></div>
                    <div href="#" class="search"><img src="http://wearska.com/ska/wp-content/uploads/2015/03/magnifier12.svg" alt="logo"/></div>
                </div>
            </div>
		</header>
		<!-- #masthead -->
		
		<div id="content" class="row">
            <div id="page-content"></div>
            <nav id="navigation" class="sticky-left">
                <div class="overlay faster-transition transparent"></div>
                <div class="mainnav">
                    <div class="featured"><img src='<?php echo $featuredLogo["url"]?>' alt="logo" /></div>
                    <!-- START NAVIGATION MENU ITEMS -->
                    <?php 
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container' => 'false',
                            'fallback_cb' => 'show_top_menu',
                            'menu_class' => 'menu',
                            'menu_id' => 'nav',
                            'echo' => true,
                            'walker' => new wsk_walker(),
                            'depth' => 0 
                        )); 
                    ?>
                    <!-- END NAVIGATION MENU ITEMS -->	
                </div>
            </nav>
		<!-- #site-navigation -->