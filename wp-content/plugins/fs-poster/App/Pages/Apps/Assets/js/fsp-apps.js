'use strict';

( function ( $ ) {
	let doc = $( document );

	doc.ready( function () {
		doc.on( 'click', '.fsp-delete-app', function () {
			let _this = $( this );
			let id = _this.data( 'id' );
			let appDiv = $( `.fsp-app[data-id="${ id }"]` );

			if ( id )
			{
				FSPoster.confirm( fsp__( 'Are you sure you want to delete?' ), function () {
					FSPoster.ajax( 'delete_app', { id }, function () {
						appDiv.fadeOut( 300, function () {
							$( this ).remove();

							if ( $( '.fsp-app' ).length === 0 )
							{
								$( '#fspNoAppFound' ).removeClass( 'fsp-hide' );
							}

							$( '#fspAppsCount' ).text( parseInt( $( '#fspAppsCount' ).text() ) - 1 );
							$( '.fsp-tab.fsp-is-active .fsp-tab-all' ).text( parseInt( $( '.fsp-tab.fsp-is-active .fsp-tab-all' ).text() ) - 1 );
						} );
					} );
				} );
			}
		} ).on( 'click', '.fsp-modal-footer > #fspModalAddButton', function () {
			let appID = $( '#fspAppID' ).val().trim();
			let appKey = $( '#fspAppKey' ).val().trim();
			let appSecret = $( '#fspAppSecret' ).val().trim();
			let botToken = $( '#fspBotToken' ).val().trim();
			let appVersion = $( '#fspAppVersion' ).val().trim();
			let driver = $( '#fspAppDriver' ).val().trim();

			FSPoster.ajax( 'add_new_app', {
				app_id: appID,
				app_key: appKey,
				app_secret: appSecret,
				bot_token: botToken,
				driver: driver,
				version: appVersion
			}, function ( res ) {
				FSPoster.toast( res[ 'message' ], 'success' );
				FSPoster.loading( true );

				window.location.reload();
			} );
		} );
	} );
} )( jQuery );
