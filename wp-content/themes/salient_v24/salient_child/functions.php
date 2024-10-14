<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
?>

<?php 

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
    if ( is_rtl() ) {
   		wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}
?>

<?php
// Load the parent theme's functions.php
if ( ! function_exists( 'parent_theme_functions' ) ) {
    function parent_theme_functions() {
        require_once( get_template_directory() . '/functions.php' );
    }
    add_action( 'after_setup_theme', 'parent_theme_functions' );
}
?>

<?php
add_action('init', 'start_session', 1);

function start_session()
{
    session_set_cookie_params([
        'lifetime' => 0,   // session
        'path' => '/',
        'domain' => '',       // Set your domain if needed
        'secure' => true,     // Ensures cookies are sent over HTTPS
        'httponly' => true,   // Prevents JavaScript access to session cookie
        'samesite' => 'Lax'   // Protects against CSRF attacks
    ]);
    session_start();
        
    set_session_item('posts_default', 15);
    set_session_item('posts_max', $_SESSION['posts_default']);
    set_session_item('page_range', 5);
 //       $_SESSION['post_ids'] = '';
}
?>

<?php
function initialize_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        if (!isset($_SESSION['initialized'])) {
            $_SESSION['initialized'] = true;
        }
    }
}

function set_session_item($key, $value) {
    initialize_session();
    $_SESSION[$key] = $value;
    session_write_close();
}
?>

<?php
 /****************MRR**********************/
/* Our research filter Custom code start */
require_once('browser.php');
require_once('research.php');
require_once('teamtemplate.php');
//require 'salient_child\browser.php';
//require 'salient_child\research.php';
//require 'salient_child\teamtemplate.php';
/* Our research filter Custom code end */

function recaptchaCheck() {
		remove_action( 'wp_enqueue_scripts', 'wpcf7_recaptcha_enqueue_scripts' );
}
?>

<?php
//************** Team Template ****************
//add_shortcode( 'team_builder', 'get_team_builder' );
//*********** End team template ****************
?>
