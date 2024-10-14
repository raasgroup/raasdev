<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Raas_Admin' ) ) :

	/**
	 * Main Raas_Admin Class.
	 *
	 * @package		RAASADMIN
	 * @subpackage	Classes/Raas_Admin
	 * @since		1.0.0
	 * @author		Mark Reay
	 */
	final class Raas_Admin {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Raas_Admin
		 */
		private static $instance;

		/**
		 * RAASADMIN helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Raas_Admin_Helpers
		 */
		public $helpers;

		/**
		 * RAASADMIN settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Raas_Admin_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'raas-admin' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'raas-admin' ), '1.0.0' );
		}

		/**
		 * Main Raas_Admin Instance.
		 *
		 * Insures that only one instance of Raas_Admin exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Raas_Admin	The one true Raas_Admin
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Raas_Admin ) ) {
				self::$instance					= new Raas_Admin;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Raas_Admin_Helpers();
				self::$instance->settings		= new Raas_Admin_Settings();

				//Fire the plugin logic
				new Raas_Admin_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'RAASADMIN/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once RAASADMIN_PLUGIN_DIR . 'core/includes/classes/class-raas-admin-helpers.php';
			require_once RAASADMIN_PLUGIN_DIR . 'core/includes/classes/class-raas-admin-settings.php';

			require_once RAASADMIN_PLUGIN_DIR . 'core/includes/classes/class-raas-admin-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'raas-admin', FALSE, dirname( plugin_basename( RAASADMIN_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.