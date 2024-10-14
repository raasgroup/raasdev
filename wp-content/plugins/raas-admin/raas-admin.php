<?php
/**
 * RaaS Admin
 *
 * @package       RAASADMIN
 * @author        Mark Reay
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   RaaS Admin
 * Plugin URI:    http://192.168.0.77
 * Description:   Control various raas functions 
 * Version:       1.0.0
 * Author:        Mark Reay
 * Author URI:    http:192.168.0.77
 * Text Domain:   raas-admin
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'RAASADMIN_NAME',			'RaaS Admin' );

// Plugin version
define( 'RAASADMIN_VERSION',		'1.0.0' );

// Plugin Root File
define( 'RAASADMIN_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'RAASADMIN_PLUGIN_BASE',	plugin_basename( RAASADMIN_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'RAASADMIN_PLUGIN_DIR',	plugin_dir_path( RAASADMIN_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'RAASADMIN_PLUGIN_URL',	plugin_dir_url( RAASADMIN_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once RAASADMIN_PLUGIN_DIR . 'core/class-raas-admin.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Mark Reay
 * @since   1.0.0
 * @return  object|Raas_Admin
 */
function RAASADMIN() {
	return Raas_Admin::instance();
}

RAASADMIN();

/**
 * Registers the raas-admin post type.
 */
function raas_admin_register_post_types() {

	// Set UI labels for the recipes post type.
	$labels = array(
		'name' => _x( 'Recipes', 'Post Type General Name', 'hot-recipes' ),
		'singular_name' => _x( 'Recipe', 'Post Type Singular Name', 'hot-recipes' ),
		'menu_name' => __( 'Recipes', 'hot-recipes' ),
		'parent_item_colon' => __( 'Parent Recipe', 'hot-recipes' ),
		'all_items' => __( 'All Recipes', 'hot-recipes' ),
		'view_item' => __( 'View Recipe', 'hot-recipes' ),
		'add_new_item' => __( 'Add New Recipe', 'hot-recipes' ),
		'add_new' => __( 'Add New', 'hot-recipes' ),
		'edit_item' => __( 'Edit Recipe', 'hot-recipes' ),
		'update_item' => __( 'Update Recipe', 'hot-recipes' ),
		'search_items' => __( 'Search Recipe', 'hot-recipes' ),
		'not_found' => __( 'Not Found', 'hot-recipes' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'hot-recipes' ),
	);

	// Set other arguments for the recipes post type.
	$args = array(
		'label' => __( 'recipes', 'hot-recipes' ),
		'description' => __( 'Recipes.', 'hot-recipes' ),
		'labels' => $labels,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'comments',
			'revisions',
			'custom-fields',
		),
		'taxonomies' => array(),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'show_in_rest' => true,
	);

	// Registes the recipes post type.
	register_post_type( 'recipes', $args );

}
add_action( 'init', 'raas_admin_register_post_types' );