/**
 * Liive-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	var $style = $( '#charmeem-color-scheme-css' ),
		api = wp.customize;
		
	if ( ! $style.length ) {
		$style = $( 'head' ).append( '<style type="text/css" id="charmeem-color-scheme-css" />' )
		                    .find( '#charmeem-color-scheme-css' );
							
	}

	// Site title.
	api( 'blogname', function( value ) {
	
				
	value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site tagline.
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {  // api is binding CUSTOM EVENT 'preview-ready'
											 // this custom event is triggered from file '/include/customize-preview.js'
											 
		// Listen to the 'update-color-scheme-css' event which is triggered from previewer in 'color-scheme-control.js' file
		api.preview.bind( 'update-color-scheme-css', function( css ) { 
		
			$style.html( css );
		} );
	} );

} )( jQuery );
