<?php

namespace SG_Email_Marketing\Install_Service;

use \SG_Email_Marketing\Install_Service\Install_1_1_1;

/**
 * Define the Install interface.
 *
 * @since  1.1.1
 */
class Install_Service {

	/**
	 * Installs
	 *
	 * @var array
	 */
	public $installs;

	/**
	 * The constructor.
	 *
	 * @since 1.1.1
	 */
	public function __construct() {
		// Get the install services.
		$this->installs = array(
			new Install_1_1_1(),
		);
	}

	/**
	 * Loop through all versions and install the updates.
	 *
	 * @since 1.1.1
	 *
	 * @return void
	 */
	public function install() {
		// Use a transient to avoid concurrent installation calls.
		if ( $this->install_required() && false === get_transient( '_sg_email_marketing_installing' ) ) {
			set_transient( '_sg_email_marketing_installing', true, 5 * MINUTE_IN_SECONDS );

			// Do the install.
			$this->do_install();

			// Delete the transient after the install.
			delete_transient( '_sg_email_marketing_installing' );
		}
	}

	/**
	 * Perform the actual installation.
	 *
	 * @since 1.1.1
	 */
	private function do_install() {

		$version = null;

		foreach ( $this->installs as $install ) {
			// Get the install version.
			$version = $install->get_version();

			if ( version_compare( $version, $this->get_current_version(), '>' ) ) {
				// Install version.
				$install->install();

				// Bump the version.
				update_option( 'sg_email_marketing_version', $version );

				update_option( 'sg_email_marketing_update_timestamp', time() );
			}
		}
	}

	/**
	 * Retrieve the current version.
	 *
	 * @return type
	 */
	private function get_current_version() {
		return get_option( 'sg_email_marketing_version', '0.0.0' );
	}

	/**
	 * Checks whether update is required.
	 *
	 * @since  1.1.1
	 *
	 * @return bool True/false/
	 */
	private function install_required() {
		foreach ( $this->installs as $install ) {
			// Get the install version.
			$version = $install->get_version();

			if ( version_compare( $version, $this->get_current_version(), '>' ) ) {
				return true;
			}
		}

		return false;
	}
}
