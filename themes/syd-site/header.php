<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package syd-site
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'syd-site' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><span><?php bloginfo( 'name' ); ?><span></h1>
				<h1 class="site-description"><?php bloginfo( 'description' ); ?></h1>
				<?php
			else :
				?>
				<h1 class="site-title"><span><?php bloginfo( 'name' ); ?><span></h1>
				<h1 class="site-description"><?php bloginfo( 'description' ); ?></h1>
				<?php
			endif;
				?>
	
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
