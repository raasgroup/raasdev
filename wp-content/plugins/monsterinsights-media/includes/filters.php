<?php

function monsterinsights_media_allow_youtube_tracking( $oembed ) {
	if ( ! is_admin() ) {
		return str_replace( 'feature=oembed', 'feature=oembed&enablejsapi=1', $oembed );
	}
	return $oembed;
}

/**
 * Alternatively, embed_oembed_html can be used. However, oembed_result might be
 * more performant as it is applied before the oEmbed response is cached as a _oembed_* meta entry.
 * https://developer.wordpress.org/reference/hooks/oembed_result/#comment-2330*
 */
add_filter( 'oembed_result', 'monsterinsights_media_allow_youtube_tracking' );


/**
 * Add video tracking feature to videos added before the Media Addon was available
 * to public.
 *
 * @param string $content Post Content.
 *
 * @return string
 */
function monsterinsights_track_old_videos( $content ) {
	$media  = get_media_embedded_in_content( $content, array( 'iframe' ) );

	if ( empty( $media ) ) {
		return $content;
	}

	$search_replace = [];

	foreach ( $media as $video ) {
		preg_match( '/src=[\"|\'](?<src>(https?:)?(?:\/\/)?(?:www.)?(?:youtube\.com|youtu\.be|youtube-nocookie\.com)\/.*?(?<enablejsapi>enablejsapi=1.*?)?)[\"|\']/i', $video, $result );
		if ( empty( $result ) ) {
			continue;
		}

		if ( ! empty( $result['enablejsapi'] ) ) {
			continue;
		}

		$search_replace[ $result['src'] ] = add_query_arg( 'enablejsapi', '1', $result['src'] );
	}

	if ( empty( $search_replace ) ) {
		return $content;
	}

	return str_replace( array_keys( $search_replace ), array_values( $search_replace ), $content );
}
add_filter( 'the_content', 'monsterinsights_track_old_videos', PHP_INT_MAX - 10 );
add_filter( 'widget_block_content', 'monsterinsights_track_old_videos', PHP_INT_MAX - 10 );
