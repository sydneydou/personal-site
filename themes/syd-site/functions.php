<?php
/**
 * syd-site functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package syd-site
 */

if ( ! function_exists( 'syd_site_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function syd_site_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on syd-site, use a find and replace
		 * to change 'syd-site' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'syd-site', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'syd-site' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'syd_site_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'syd_site_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function syd_site_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'syd_site_content_width', 640 );
}
add_action( 'after_setup_theme', 'syd_site_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function syd_site_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'syd-site' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'syd-site' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'syd_site_widgets_init' );



/**
 * Filter the stylesheet_uri to output the minified CSS file.
 */
function inhabitent_theme_minified_css( $stylesheet_uri, $stylesheet_dir_uri ) {
	if ( file_exists( get_template_directory() . '/build/css/style.min.css' ) ) {
		$stylesheet_uri = $stylesheet_dir_uri . '/build/css/style.min.css';
	}

	return $stylesheet_uri;
}
add_filter( 'stylesheet_uri', 'inhabitent_theme_minified_css', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function syd_site_scripts() {
	wp_enqueue_style( 'syd-site-style', get_stylesheet_uri());
	

	wp_enqueue_script( 'syd-site-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'syd-site-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'syd_site_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Dev Project', 'text_domain' ),
		'name_admin_bar'        => __( 'Dev Project', 'text_domain' ),
		'archives'              => __( 'Dev Project Archives', 'text_domain' ),
		'attributes'            => __( 'Dev Project Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Project:', 'text_domain' ),
		'all_items'             => __( 'All Dev Projects', 'text_domain' ),
		'add_new_item'          => __( 'Add New Dev Project', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Dev Project', 'text_domain' ),
		'edit_item'             => __( 'Edit Dev Project', 'text_domain' ),
		'update_item'           => __( 'Update Dev Project', 'text_domain' ),
		'view_item'             => __( 'View Dev Project', 'text_domain' ),
		'view_items'            => __( 'View Dev Projects', 'text_domain' ),
		'search_items'          => __( 'Search Dev Projects', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Dev Project', 'text_domain' ),
		'items_list'            => __( 'Dev Projects list', 'text_domain' ),
		'items_list_navigation' => __( 'Dev Projects list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Dev Projects list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Project', 'text_domain' ),
		'description'           => __( 'Development Projects', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'projects', $args );

}
add_action( 'init', 'custom_post_type', 0 );

// // Register Custom Taxonomy
// function project_taxonomy() {

// 	$labels = array(
// 		'name'                       => _x( 'Project Types', 'Taxonomy General Name', 'text_domain' ),
// 		'singular_name'              => _x( 'Project Type', 'Taxonomy Singular Name', 'text_domain' ),
// 		'menu_name'                  => __( 'Project Type', 'text_domain' ),
// 		'all_items'                  => __( 'All Project Types', 'text_domain' ),
// 		'parent_item'                => __( 'Parent Project Type', 'text_domain' ),
// 		'parent_item_colon'          => __( 'Parent Project Type:', 'text_domain' ),
// 		'new_item_name'              => __( 'New Project Type', 'text_domain' ),
// 		'add_new_item'               => __( 'Add New Project Type', 'text_domain' ),
// 		'edit_item'                  => __( 'Edit Project Type', 'text_domain' ),
// 		'update_item'                => __( 'Update Project Type', 'text_domain' ),
// 		'view_item'                  => __( 'View Project Type', 'text_domain' ),
// 		'separate_items_with_commas' => __( 'SeparateProject Type with commas', 'text_domain' ),
// 		'add_or_remove_items'        => __( 'Add or remove Project Types', 'text_domain' ),
// 		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
// 		'popular_items'              => __( 'Popular Project Types', 'text_domain' ),
// 		'search_items'               => __( 'Search Project Types', 'text_domain' ),
// 		'not_found'                  => __( 'Not Found', 'text_domain' ),
// 		'no_terms'                   => __( 'No Project Types', 'text_domain' ),
// 		'items_list'                 => __( 'Project Types list', 'text_domain' ),
// 		'items_list_navigation'      => __( 'Project Types list navigation', 'text_domain' ),
// 	);
// 	$args = array(
// 		'labels'                     => $labels,
// 		'hierarchical'               => false,
// 		'public'                     => true,
// 		'show_ui'                    => true,
// 		'show_admin_column'          => true,
// 		'show_in_nav_menus'          => true,
// 		'show_tagcloud'              => true,
// 	);
// 	register_taxonomy( 'project_taxonomy', array( 'post' ), $args );

// }
// add_action( 'init', 'project_taxonomy', 0 );

add_filter('acf/settings/remove_wp_meta_box', '__return_false');