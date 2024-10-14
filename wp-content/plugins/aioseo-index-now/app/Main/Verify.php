<?php
namespace AIOSEO\Plugin\Addon\IndexNow\Main;

use WP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Verifies the IndexNow key.
 *
 * @since 1.0.0
 */
class Verify {
	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if (
			is_admin() ||
			wp_doing_ajax() ||
			wp_doing_cron() ||
			aioseo()->helpers->isRestApiRequest()
		) {
			return;
		}

		$apiKey = aioseoIndexNow()->options->indexNow->apiKey;
		if ( empty( $apiKey ) ) {
			return;
		}

		/**
		 * Hook on `parse_request` action hook in order to have the earliest access on
		 * the `WP::request` property.
		 */
		add_action( 'parse_request', [ $this, 'generateVerifyPage' ] );
	}

	/**
	 * Watch for txt requests that match the key and generates the txt file needed to verify the API key.
	 *
	 * @since 1.0.0
	 *
	 * @param  WP $wp The WordPress environment instance.
	 * @return void
	 */
	public function generateVerifyPage( $wp ) {
		if ( empty( $wp->request ) ) {
			return;
		}

		$apiKey     = aioseoIndexNow()->options->indexNow->apiKey;
		$pattern    = $apiKey . '.txt';
		$requestUri = trim( $wp->request, '/' );

		if (
			$apiKey
			&& $pattern === $requestUri
		) {
			/**
			 * Make sure this content is not buffered and prevent third-party plugins from messing with the output.
			 *
			 * @link https://github.com/awesomemotive/aioseo/issues/3820
			 */
			if ( ob_get_level() ) {
				ob_end_clean();
			}

			header( 'Content-Type: text/plain' ); // Tell the browser this page is not HTML content.
			header( 'X-Robots-Tag: noindex' );

			echo esc_html( $apiKey );
			exit;
		}
	}
}