<?php

namespace FSPoster\App\Pages\Settings\Controllers;

use FSPoster\App\Providers\Pages;
use FSPoster\App\Providers\Request;

class Main
{
	private function load_assets ()
	{
		wp_enqueue_media();
		wp_register_script( 'fsp-settings', Pages::asset( 'Settings', 'js/fsp-settings.js' ), [
			'jquery',
			'fsp'
		], NULL );
		wp_enqueue_script( 'fsp-settings' );

		wp_enqueue_style( 'fsp-settings', Pages::asset( 'Settings', 'css/fsp-settings.css' ), [ 'fsp-ui' ], NULL );
	}

	public function index ()
	{
		$this->load_assets();

		$settings_tab = Request::get( 'setting', 'general', 'string', [
			'general',
			'share',
			'url',
			'export_import',
			'fsp',
			'meta_tags',
			'facebook',
			'instagram',
			'twitter',
			'planly',
			'linkedin',
			'pinterest',
			'telegram',
			'reddit',
			'youtube_community',
			'tumblr',
			'ok',
			'vk',
			'google_b',
			'medium',
			'wordpress',
			'blogger',
			'plurk',
			'xing',
			'discord',
		] );

		Pages::view( 'Settings', 'index', [
			'active_tab' => $settings_tab
		] );
	}

	public function component_share ()
	{
		wp_register_script( 'fsp-settings-share', Pages::asset( 'Settings', 'js/fsp-settings-share.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-share' );

		Pages::view( 'Settings', 'Components/share', [
			'cronJobsCode' => 'wget -O /dev/null ' . site_url() . '/?fs-poster-cron-job=1 >/dev/null 2>&1'
		] );
	}

	public function component_general ()
	{
		wp_register_script( 'fsp-settings-general', Pages::asset( 'Settings', 'js/fsp-settings-general.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-general' );

		Pages::view( 'Settings', 'Components/general' );
	}

	public function component_url ()
	{
		wp_register_script( 'fsp-settings-url', Pages::asset( 'Settings', 'js/fsp-settings-url.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-url' );

		Pages::view( 'Settings', 'Components/url' );
	}

	public function component_export_import ()
	{
		wp_register_script( 'fsp-settings-export_import', Pages::asset( 'Settings', 'js/fsp-settings-export_import.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-export_import' );

		Pages::view( 'Settings', 'Components/export_import' );
	}

	public function component_meta_tags ()
	{
		wp_register_script( 'fsp-settings-meta_tags', Pages::asset( 'Settings', 'js/fsp-settings-meta_tags.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-meta_tags' );

		Pages::view( 'Settings', 'Components/meta_tags' );
	}

	public function component_facebook ()
	{
		wp_register_script( 'fsp-settings-facebook', Pages::asset( 'Settings', 'js/fsp-settings-facebook.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-facebook' );

		Pages::view( 'Settings', 'Components/facebook' );
	}

	public function component_instagram ()
	{
		wp_register_script( 'fsp-color', 'https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.2.1/jscolor.min.js' );
		wp_enqueue_script( 'fsp-color' );
		wp_register_script( 'fsp-settings-instagram', Pages::asset( 'Settings', 'js/fsp-settings-instagram.js' ), [ 'fsp-color' ], NULL );
		wp_enqueue_script( 'fsp-settings-instagram' );

		Pages::view( 'Settings', 'Components/instagram' );
	}

	public function component_twitter ()
	{
		wp_register_script( 'fsp-settings-twitter', Pages::asset( 'Settings', 'js/fsp-settings-twitter.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-twitter' );

		Pages::view( 'Settings', 'Components/twitter' );
	}

	public function component_linkedin ()
	{
		wp_register_script( 'fsp-settings-linkedin', Pages::asset( 'Settings', 'js/fsp-settings-linkedin.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-linkedin' );

		Pages::view( 'Settings', 'Components/linkedin' );
	}

	public function component_vk ()
	{
		wp_register_script( 'fsp-settings-vk', Pages::asset( 'Settings', 'js/fsp-settings-vk.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-vk' );

		Pages::view( 'Settings', 'Components/vk' );
	}

	public function component_pinterest ()
	{
		wp_register_script( 'fsp-settings-pinterest', Pages::asset( 'Settings', 'js/fsp-settings-pinterest.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-pinterest' );

		Pages::view( 'Settings', 'Components/pinterest' );
	}

	public function component_tumblr ()
	{
		wp_register_script( 'fsp-settings-tumblr', Pages::asset( 'Settings', 'js/fsp-settings-tumblr.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-tumblr' );

		Pages::view( 'Settings', 'Components/tumblr' );
	}

	public function component_reddit ()
	{
		wp_register_script( 'fsp-settings-reddit', Pages::asset( 'Settings', 'js/fsp-settings-reddit.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-reddit' );

		Pages::view( 'Settings', 'Components/reddit' );
	}

	public function component_ok ()
	{
		wp_register_script( 'fsp-settings-ok', Pages::asset( 'Settings', 'js/fsp-settings-ok.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-ok' );

		Pages::view( 'Settings', 'Components/ok' );
	}

	public function component_google_b ()
	{
		wp_register_script( 'fsp-settings-google_b', Pages::asset( 'Settings', 'js/fsp-settings-google_b.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-google_b' );

		Pages::view( 'Settings', 'Components/google_b' );
	}

	public function component_blogger ()
	{
		wp_register_script( 'fsp-settings-blogger', Pages::asset( 'Settings', 'js/fsp-settings-blogger.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-blogger' );

		Pages::view( 'Settings', 'Components/blogger' );
	}

	public function component_telegram ()
	{
		wp_register_script( 'fsp-settings-telegram', Pages::asset( 'Settings', 'js/fsp-settings-telegram.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-telegram' );

		Pages::view( 'Settings', 'Components/telegram' );
	}

	public function component_medium ()
	{
		wp_register_script( 'fsp-settings-medium', Pages::asset( 'Settings', 'js/fsp-settings-medium.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-medium' );

		Pages::view( 'Settings', 'Components/medium' );
	}

	public function component_wordpress ()
	{
		wp_register_script( 'fsp-settings-wordpress', Pages::asset( 'Settings', 'js/fsp-settings-wordpress.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-wordpress' );

		Pages::view( 'Settings', 'Components/wordpress' );
	}

	public function component_plurk ()
	{
		wp_register_script( 'fsp-settings-plurk', Pages::asset( 'Settings', 'js/fsp-settings-plurk.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-plurk' );

		Pages::view( 'Settings', 'Components/plurk' );
	}

	public function component_xing ()
	{
		wp_register_script( 'fsp-settings-xing', Pages::asset( 'Settings', 'js/fsp-settings-xing.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-xing' );

		Pages::view( 'Settings', 'Components/xing' );
	}

	public function component_discord ()
	{
		wp_register_script( 'fsp-settings-discord', Pages::asset( 'Settings', 'js/fsp-settings-discord.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-discord' );

		Pages::view( 'Settings', 'Components/discord' );
	}

	public function component_youtube_community ()
	{
		wp_register_script( 'fsp-settings-youtube-community', Pages::asset( 'Settings', 'js/fsp-settings-youtube-community.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-youtube-community' );

		Pages::view( 'Settings', 'Components/youtube_community' );
	}

	public function component_planly ()
	{
		wp_register_script( 'fsp-settings-planly', Pages::asset( 'Settings', 'js/fsp-settings-planly.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-planly' );

		Pages::view( 'Settings', 'Components/planly' );
	}

	public function component_fsp ()
	{
		wp_register_script( 'fsp-settings-fsp', Pages::asset( 'Settings', 'js/fsp-settings-fsp.js' ), [], NULL );
		wp_enqueue_script( 'fsp-settings-fsp' );

		Pages::view( 'Settings', 'Components/fsp' );
	}
}
