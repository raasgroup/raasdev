<?php

namespace FSPoster\App\Pages\Apps\Controllers;

use FSPoster\App\Providers\DB;
use FSPoster\App\Libraries\vk\Vk;
use FSPoster\App\Providers\Request;
use FSPoster\App\Libraries\plurk\Plurk;
use FSPoster\App\Libraries\fb\Facebook;
use FSPoster\App\Libraries\reddit\Reddit;
use FSPoster\App\Libraries\tumblr\Tumblr;
use FSPoster\App\Libraries\medium\Medium;
use FSPoster\App\Libraries\blogger\Blogger;
use FSPoster\App\Libraries\ok\OdnoKlassniki;
use FSPoster\App\Libraries\linkedin\Linkedin;
use FSPoster\App\Libraries\pinterest\Pinterest;
use FSPoster\App\Libraries\google\GoogleMyBusinessAPI;
use FSPoster\App\Libraries\instagram\InstagramAppMethod;
use FSPoster\App\Libraries\discord\Discord;

class Action
{
	public function get_apps ()
	{
		$appsCount = DB::DB()->get_results( "SELECT driver, COUNT(0) AS _count FROM " . DB::table( 'apps' ) . " WHERE IFNULL( `slug`, '')='' AND NOT ( (driver='vk' OR driver='plurk') AND user_id IS NULL ) GROUP BY driver", ARRAY_A );
		$appCounts = [
			'total'     => 0,
			'fb'        => [ 0, [ 'app_id', 'app_secret' ] ],
			'instagram' => [ 0, [ 'app_id', 'app_key' ] ],
			'twitter'   => [ 0, [ 'app_key', 'app_secret' ] ],
			'linkedin'  => [ 0, [ 'app_id', 'app_secret' ] ],
			'vk'        => [ 0, [ 'app_id', 'app_secret' ] ],
			'pinterest' => [ 0, [ 'app_id', 'app_secret' ] ],
			'reddit'    => [ 0, [ 'app_id', 'app_secret' ] ],
			'tumblr'    => [ 0, [ 'app_key', 'app_secret' ] ],
			'ok'        => [ 0, [ 'app_id', 'app_key', 'app_secret' ] ],
			'plurk'     => [ 0, [ 'app_key', 'app_secret' ] ],
			'medium'    => [ 0, [ 'app_id', 'app_secret' ] ],
			'google_b'  => [ 0, [ 'app_id', 'app_secret' ] ],
			'blogger'   => [ 0, [ 'app_id', 'app_secret' ] ],
			'discord'   => [ 0, [ 'app_id', 'bot_token' ] ]
		];

		foreach ( $appsCount as $a_info )
		{
			if ( isset( $appCounts[ $a_info[ 'driver' ] ] ) )
			{
				$appCounts[ $a_info[ 'driver' ] ][ 0 ] = $a_info[ '_count' ];
				$appCounts[ 'total' ]                  += $a_info[ '_count' ];
			}
		}

		$active_tab = Request::get( 'tab', 'fb', 'string' );

		if ( ! array_key_exists( $active_tab, $appCounts ) )
		{
			$active_tab = 'fb';
		}

		$appList = DB::DB()->get_results( DB::DB()->prepare(  'SELECT * FROM ' . DB::table( 'apps' ) . ' WHERE driver=%s AND IFNULL( `slug`, \'\')=\'\' AND NOT ( (driver=\'vk\' OR driver=\'plurk\') AND user_id IS NULL )', [ $active_tab ] ), ARRAY_A );

		foreach ( $appList as &$app )
		{
			if ( ! empty( $app[ 'data' ] ) )
			{
				$data = json_decode( $app[ 'data' ], true );
				$app  = array_merge( $app, $data );
			}

			unset( $app[ 'data' ] );
		}

		$callback_urls = [
			'fb'        => Facebook::callbackURL(),
			'instagram' => InstagramAppMethod::callbackURL(),
			'twitter'   => site_url() . '/',
			'linkedin'  => Linkedin::callbackURL(),
			'vk'        => Vk::callbackURL(),
			'pinterest' => Pinterest::callbackURL(),
			'reddit'    => Reddit::callbackURL(),
			'tumblr'    => Tumblr::callbackURL(),
			'ok'        => OdnoKlassniki::callbackURL(),
			'plurk'     => Plurk::callbackURL(),
			'medium'    => Medium::callbackURL(),
			'google_b'  => GoogleMyBusinessAPI::callbackURL(),
			'blogger'   => Blogger::callbackURL(),
			'discord'   => Discord::callbackURL()
		];

		if ( ! empty( $callback_urls[ $active_tab ] ) )
		{
			$callbackUrl = $callback_urls[ $active_tab ];
		}
		else
		{
			$callbackUrl = '-';
		}

		return [
			'appCounts'   => $appCounts,
			'callbackUrl' => $callbackUrl,
			'appList'     => isset( $appList ) ? $appList : NULL,
			'active_tab'  => $active_tab
		];
	}
}